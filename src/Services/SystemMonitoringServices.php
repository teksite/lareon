<?php

namespace Teksite\Lareon\Services;

class SystemMonitoringServices
{
    public function getSystemUsage(): array
    {
        return match (PHP_OS_FAMILY) {
            'Windows' => $this->getWindowsUsage(),
            default => $this->getLinuxUsage(),
        };
    }

    private function getLinuxUsage(): array
    {
        return [
            'cpu' => trim(shell_exec("top -bn1 | grep 'Cpu(s)' | awk '{print $2 + $4}'")) . '%',
            'memory' => trim(shell_exec("free -m | awk 'NR==2{printf \"%s/%s MB (%.2f%%)\", $3,$2,$3*100/$2 }'")),
            'disk' => trim(shell_exec("df -h / | awk 'NR==2{print $3\"/\"$2 \" (\" $5 \")\"}'")),
        ];
    }

    private function getWindowsUsage(): array
    {
        $cpu = trim(shell_exec('wmic cpu get LoadPercentage /value'));
        $cpu = explode("=", $cpu)[1] ?? 'N/A';

        $memory = shell_exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /value');
        preg_match_all('/\d+/', $memory, $matches);
        if (isset($matches[0][1]) && isset($matches[0][0])) {
            $totalMem = (int) $matches[0][1] / 1024;
            $freeMem = (int) $matches[0][0] / 1024;
            $usedMem = $totalMem - $freeMem;
            $memoryUsage = sprintf("%s/%s MB (%.2f%%)", $usedMem, $totalMem, ($usedMem / $totalMem) * 100);
        } else {
            $memoryUsage = 'N/A';
        }

        $disk = shell_exec('wmic logicaldisk get Size,FreeSpace /value');
        preg_match_all('/\d+/', $disk, $matches);
        if (isset($matches[0][1]) && isset($matches[0][0])) {
            $totalDisk = (int) $matches[0][1] / (1024 ** 3);
            $freeDisk = (int) $matches[0][0] / (1024 ** 3);
            $usedDisk = $totalDisk - $freeDisk;
            $diskUsage = sprintf("%s/%s GB (%.2f%%)", $usedDisk, $totalDisk, ($usedDisk / $totalDisk) * 100);
        } else {
            $diskUsage = 'N/A';
        }

        return [
            'cpu' => $cpu . '%',
            'memory' => $memoryUsage,
            'disk' => $diskUsage,
        ];
    }

}
