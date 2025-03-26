<?php

namespace Lareon\CMS\App\Logic;

use Illuminate\Support\Facades\DB;
use PDO;
use SQLite3;

class AppInfoLogic
{
    public const WINDOWS = 'WINDOWS';
    public const LINUX = 'LINUX';

    public function get(null|string|array $category = null): array
    {
        $output = shell_exec("C:\\Windows\\System32\\wbem\\wmic.exe cpu get Name /value 2>&1");
        $data = [
            'general' => $this->getGeneralInfo(),
            'os' => $this->getOsInfo(),
            'database' => $this->getDatabaseInfo(),
            'hardware' => $this->getHardwareInfo(),
            'extensions' => $this->getPhpExtensions(),
            'required_packages' => $this->getComposerPackages('require'),
            'dev_required_packages' => $this->getComposerPackages('require-dev'),
        ];

        return $category ? $this->filterByCategory($data, $category) : $data;
    }

    public function getGeneralInfo(): array
    {
        return [
            'php_version' => phpversion(),
            'laravel_version' => app()->version(),
            'server_time' => now()->toDateTimeString(),
            'env' => app()->environment(),
            'cache_driver' => config('cache.default'),
            'session_driver' => config('session.driver'),
        ];
    }

    public function getOsInfo(): array
    {
        return [
            'name' => php_uname('s') . ' ' . php_uname('r'),
            'timezone' => date_default_timezone_get() ?: 'Unknown',
            'web_server' => $this->getWebServer() ?? 'Unknown',

        ];
    }

    public function getDatabaseInfo(): array
    {
        $connectionName = config('database.default');
        $driver = config("database.connections.{$connectionName}.driver");

        return [
            'connection' => $connectionName,
            'driver' => $driver,
            'version' => $this->getDatabaseVersion($driver),
            'database' => $this->getDatabaseName($driver, $connectionName),
        ];
    }
    public function getWebServer(): string
    {
        $serverSoftware = $_SERVER['SERVER_SOFTWARE'] ?? '';

        // اگر مقدار $_SERVER['SERVER_SOFTWARE'] مقدار قابل تشخیصی داشت
        if (!empty($serverSoftware)) {
            if (stripos($serverSoftware, 'Apache') !== false) {
                return 'Apache';
            }
            if (stripos($serverSoftware, 'nginx') !== false) {
                return 'Nginx';
            }
            if (stripos($serverSoftware, 'Microsoft-IIS') !== false) {
                return 'IIS';
            }
            return $serverSoftware;
        }

        // اگر مقدار بالا مشخص نشد، بررسی مجدد برای Apache
        if (function_exists('apache_get_version')) {
            return 'Apache';
        }

        // بررسی Nginx در سیستم‌های لینوکسی
        if (strtoupper(PHP_OS_FAMILY) !== 'WINDOWS') {
            $nginxCheck = shell_exec('ps aux | grep nginx');
            if ($nginxCheck && stripos($nginxCheck, 'nginx') !== false) {
                return 'Nginx';
            }
        }

        return 'Unknown';
    }
    public function getHardwareInfo(): array
    {
        return [
            'cpu' => $this->getCpuInfo(),
            'ram' => $this->getRamInfo(),
            'disk' => $this->getDiskInfo(),
        ];
    }

    public function filterByCategory(array $data, string|array $category): array
    {
        $categories = (array) $category;
        return array_intersect_key($data, array_flip($categories));
    }

    public function getDatabaseVersion(string $driver): string
    {
        try {
            $pdo = DB::connection()->getPdo();
            return match ($driver) {
                'mysql', 'mariadb' => $pdo->query('SELECT VERSION()')->fetchColumn() ?: 'Unknown',
                'pgsql' => $pdo->query('SHOW server_version')->fetchColumn() ?: 'Unknown',
                'sqlite' => SQLite3::version()['versionString'] ?? 'Unknown',
                'sqlsrv' => $pdo->query('SELECT SERVERPROPERTY("productversion")')->fetchColumn() ?: 'Unknown',
                'redis' => phpversion('redis') ?: 'Unknown', // Redis معمولاً نسخه سرور رو از PHP نمی‌گیره
                default => 'Unknown',
            };
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    public function getDatabaseName(string $driver, string $connectionName): string
    {
        $config = config("database.connections.{$connectionName}");
        return match ($driver) {
            'mysql', 'mariadb', 'pgsql', 'sqlsrv' => $config['database'] ?? 'Unknown',
            'sqlite' => $config['database'] ? basename($config['database']) : 'Unknown',
            'redis' => $config['database'] ?? 'N/A', // Redis معمولاً "دیتابیس" به معنای سنتی نداره
            default => 'Unknown',
        };
    }

    public function getCpuInfo(): array
    {
        return strtoupper(PHP_OS_FAMILY) === self::WINDOWS
            ? $this->getWindowsCpuInfo()
            : $this->getLinuxCpuInfo();

    }

    public function getWindowsCpuInfo(): array
    {
        return [
            'model' => $this->parseWmicOutput('cpu get Name', 'Name'),
            'cores' => $this->parseWmicOutput('cpu get NumberOfCores', 'NumberOfCores'),
            'cpu_usage' => $this->getCpuUsage(),
        ];
    }

    public function getLinuxCpuInfo(): array
    {
        if (!is_readable('/proc/cpuinfo')) {
            return ['model' => 'Unknown', 'cores' => 'Unknown'];
        }

        $cpuInfo = file_get_contents('/proc/cpuinfo');
        preg_match('/model name\s+: (.+)/', $cpuInfo, $matches);

        return [
            'model' => $matches[1] ?? 'Unknown',
            'cores' => substr_count($cpuInfo, 'processor') ?: 'Unknown',
            'cpu_usage' => $this->getCpuUsage(),
        ];
    }

    public function getCpuUsage(): string
    {
        return strtoupper(PHP_OS_FAMILY) === self::WINDOWS
            ? $this->parseWmicOutput('cpu get LoadPercentage', 'LoadPercentage', '%')
            : $this->getLinuxCpuUsage();
    }

    public function getLinuxCpuUsage(): string
    {
        return function_exists('sys_getloadavg')
            ? round(sys_getloadavg()[0], 2) . '%'
            : 'Unknown';
    }

    public function getRamInfo(): array
    {
        return strtoupper(PHP_OS_FAMILY) === self::WINDOWS
            ? $this->getWindowsRamInfo()
            : $this->getLinuxRamInfo();
    }

    public function getWindowsRamInfo(): array
    {
        $total = $this->parseWmicOutput('OS get TotalVisibleMemorySize', 'TotalVisibleMemorySize', '', 1024);
        $free = $this->parseWmicOutput('OS get FreePhysicalMemory', 'FreePhysicalMemory', '', 1024);

        return $this->formatRamInfo($total, $free);
    }

    public function getLinuxRamInfo(): array
    {
        if (!is_readable('/proc/meminfo')) {
            return $this->defaultRamInfo();
        }

        $data = array_reduce(file('/proc/meminfo'), function ($carry, $line) {
            if (preg_match('/(MemTotal|MemFree|MemAvailable):\s+(\d+)/', $line, $matches)) {
                $carry[$matches[1]] = round($matches[2] / 1024, 2);
            }
            return $carry;
        }, []);

        return $this->formatRamInfo($data['MemTotal'] ?? null, $data['MemFree'] ?? null, $data['MemAvailable'] ?? null);
    }

    public function formatRamInfo($total, $free, $available = null): array
    {
        $total = is_numeric($total) ? round($total, 2) : 'Unknown';
        $free = is_numeric($free) ? round($free, 2) : 'Unknown';
        $used = is_numeric($total) && is_numeric($free) ? round($total - $free, 2) : 'Unknown';
        $available = is_numeric($available) ? round($available, 2) : $free;

        return [
            'total' => "$total MB",
            'free' => "$free MB",
            'used' => "$used MB",
            'available' => "$available MB",
        ];
    }

    public function getDiskInfo(): array
    {
        $total = disk_total_space(base_path()) / (1024 ** 3);
        $free = disk_free_space(base_path()) / (1024 ** 3);

        return [
            'total' => $total ? round($total, 2) . ' GB' : 'Unknown',
            'free' => $free ? round($free, 2) . ' GB' : 'Unknown',
            'used' => $total && $free ? round($total - $free, 2) . ' GB' : 'Unknown',
        ];
    }

    public function getPhpExtensions(): array
    {

        $phpExtensions = get_loaded_extensions();
        sort($phpExtensions);
        $phpExtensions[]='soap';
        $extensions = [];
        foreach ($phpExtensions as $ext) {
            $extensions[$ext]=phpversion($ext);
        }
        return $extensions;
    }

    public function getComposerPackages(string $key): array
    {
        static $composerData = null;
        $composerData ??= json_decode(file_get_contents(base_path('composer.json')), true);
        return $composerData[$key] ?? [];
    }

    public function parseWmicOutput(string $command, string $key, string $suffix = '', float $divider = 1): string
    {
        if (!function_exists('shell_exec')) {
            return 'Unknown';
        }

        $output = shell_exec("wmic $command /value");
        if (!$output) {
            return 'Unknown';
        }

        foreach (explode("\n", trim($output)) as $line) {
            if (str_starts_with($line, "$key=")) {
                $value = trim(substr($line, strlen($key) + 1));
                return is_numeric($value) ? round($value / $divider, 2) . $suffix : $value;
            }
        }
        return 'Unknown';
    }

    public function defaultRamInfo(): array
    {
        return ['total' => 'Unknown', 'free' => 'Unknown', 'used' => 'Unknown', 'available' => 'Unknown'];
    }
}
