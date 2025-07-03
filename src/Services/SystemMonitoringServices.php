<?php

namespace Teksite\Lareon\Services;

class SystemMonitoringServices
{
    private string $os;
    private int $precision = 2;

    public function __construct()
    {
        $this->os = PHP_OS_FAMILY;
    }


    /**
     * @return string
     */
    public function getOs(): string
    {
        return $this->os;
    }


    public function getSystemUsage(): array
    {
        return match ($this->os) {
            'Windows' => $this->getWindowsUsage(),
            default => $this->getLinuxUsage(),
        };
    }


    public function getWindowsUsage()
    {
        return [
            'cpu' => $this->windowsCpuUsage(),
            'memory' => $this->windowsMemoryUsage(),
            'disk' => $this->windowsDiskUsage(),
        ];
    }

    public function getLinuxUsage()
    {
        return [
            'cpu' => $this->linuxCpuUsage(),
            'memory' => $this->linuxMemoryUsage(),
            'disk' => $this->linuxDiskUsage(),
        ];
    }

    /**
     * Get CPU usage in Linux
     *
     * @return array | string[]
     */
    public function linuxCpuUsage(): array
    {
        $load = sys_getloadavg();
        return [
            'percent' => $load[0] ?? 'N/A',
            'info'=>$this->linuxCpuInfo()
        ];
    }

    /**
     * Get memory data in Linux
     *
     * @return array|string[]
     */
    public function linuxMemoryUsage(): array
    {
        $memory = file_get_contents('/proc/meminfo');
        preg_match('/MemTotal:\s+(\d+)/', $memory, $total);
        preg_match('/MemAvailable:\s+(\d+)/', $memory, $available);

        if (isset($total[1]) && isset($available[1])) {
            $totalMem = (int)$total[1] / 1024;
            $freeMem = (int)$available[1] / 1024;
            $usedMem = $totalMem - $freeMem;
            return [
                'free' => round($freeMem, $this->precision),
                'used' => round($usedMem, $this->precision),
                'total' => round($totalMem, $this->precision),
                'percent' => round(($usedMem / $totalMem) * 100, $this->precision),
            ];
        }
        return [
            'used' => 'N/A',
            'total' => 'N/A',
            'percent' => 'N/A',
        ];
    }

    /**
     * Get disk data in Linux
     *
     * @return array|string[]
     */
    public function linuxDiskUsage(): array
    {
        $df = shell_exec('df / --block-size=1');
        preg_match('/\d+\s+\d+\s+(\d+)/', $df, $free);
        preg_match('/\d+\s+(\d+)\s+\d+/', $df, $used);
        preg_match('/(\d+)\s+\d+\s+\d+/', $df, $total);

        if (isset($total[1]) && isset($used[1]) && isset($free[1])) {
            $totalDisk = (int)$total[1] / (1024 ** 3);
            $freeDisk = (int)$free[1] / (1024 ** 3);
            $usedDisk = (int)$used[1] / (1024 ** 3);
            return [
                'used' => round($usedDisk, $this->precision),
                'total' => round($totalDisk, $this->precision),
                'percent' => round(($usedDisk / $totalDisk) * 100, $this->precision),
            ];
        }
        return [
            'used' => 'N/A',
            'total' => 'N/A',
            'percent' => 'N/A',
        ];
    }


    /**
     * Get cpu usage un windows
     *
     * @return array
     */
    public function windowsCpuUsage(): array
    {
        $cpu = trim(shell_exec('wmic cpu get LoadPercentage /value'));
        return [
            'percent' =>explode("=", $cpu)[1] ?? 'N/A',
            'info' =>$this->windowsCpuInfo(),
        ];
    }

    /**
     * Get Memory data in windows
     *
     * @return array|string[]
     */
    public function windowsMemoryUsage(): array
    {
        $memory = shell_exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /value');
        preg_match_all('/\d+/', $memory, $matches);
        if (isset($matches[0][1]) && isset($matches[0][0])) {
            $totalMem = (int)$matches[0][1] / 1024;
            $freeMem = (int)$matches[0][0] / 1024;
            $usedMem = $totalMem - $freeMem;
            return [
                'free' => round($freeMem, $this->precision),
                'used' => round($usedMem, $this->precision),
                'total' => round($totalMem, $this->precision),
                'percent' => round(($usedMem / $totalMem) * 100, $this->precision),
            ];
        }
        return [
            'used' => 'N/A',
            'total' => 'N/A',
            'percent' => 'N/A',
        ];
    }

    /**
     * Get disk data in windows
     *
     * @return array|string[]
     */
    public function windowsDiskUsage(): array
    {
        $disk = shell_exec('wmic logicaldisk get Size,FreeSpace /value');
        preg_match_all('/\d+/', $disk, $matches);
        if (isset($matches[0][1]) && isset($matches[0][0])) {
            $totalDisk = (int)$matches[0][1] / (1024 ** 3);
            $freeDisk = (int)$matches[0][0] / (1024 ** 3);
            $usedDisk = $totalDisk - $freeDisk;
            return [
                'used' => round($usedDisk, $this->precision),
                'total' => round($totalDisk, $this->precision),
                'percent' => round(($usedDisk / $totalDisk) * 100, $this->precision),
            ];
        }
        return [
            'used' => 'N/A',
            'total' => 'N/A',
            'percent' => 'N/A',
        ];


    }

    public function windowsCpuInfo(): array
    {
        $cpuInfo = shell_exec('wmic cpu get Name,NumberOfCores,NumberOfLogicalProcessors,MaxClockSpeed /value');
        preg_match('/Name=(.*)/', $cpuInfo, $name);
        preg_match('/NumberOfCores=(\d+)/', $cpuInfo, $cores);
        preg_match('/NumberOfLogicalProcessors=(\d+)/', $cpuInfo, $threads);
        preg_match('/MaxClockSpeed=(\d+)/', $cpuInfo, $clockSpeed);

        return [
            'name' => trim($name[1] ?? 'N/A'),
            'cores' => (int)($cores[1] ?? 0),
            'threads' => (int)($threads[1] ?? 0),
            'clock_speed' => (int)($clockSpeed[1] ?? 0) . ' MHz',
        ];
    }

    public function linuxCpuInfo(): array
    {
        $cpuInfo = file_get_contents('/proc/cpuinfo');
        preg_match('/model name\s+:\s+(.+)/', $cpuInfo, $name);
        preg_match_all('/processor\s+:/', $cpuInfo, $processors);
        preg_match('/cpu MHz\s+:\s+([\d.]+)/', $cpuInfo, $clockSpeed);

        return [
            'name' => trim($name[1] ?? 'N/A'),
            'cores' => count($processors[0] ?? []),
            'threads' => count($processors[0] ?? []), // Assuming 1 thread per core unless hyper-threading
            'clock_speed' => round((float)($clockSpeed[1] ?? 0), 2) . ' MHz',
        ];
    }
}
