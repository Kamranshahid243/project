<?php

namespace App\Console\Commands;

use App\Traits\HasLogFile;
use Illuminate\Console\Command;
use Symfony\Component\Finder\SplFileInfo;

class RemoveOldLogs extends Command
{
    use HasLogFile;
    protected $logFile = "remove-old-logs";

    protected $signature = 'nvd:remove-old-logs';
    protected $description = 'Removes older log files.';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // directory => threshold-in-days
        $directories = [
            'logs' => env('LOGS_CLEANUP_THRESHOLD', 7),
            'logs/ami-logs' => env('AMI_LOGS_CLEANUP_THRESHOLD', 3),
        ];
        foreach ($directories as $directoryName => $threshold) {
            $directory = storage_path($directoryName);
            if (!file_exists($directory)) {
                $this->log("Directory {$directory} does not exist.");
                continue;
            }

            $files = \File::allFiles($directory);
            foreach ($files as $file) {
                /* @var $file SplFileInfo */
                $mTime = $file->getMTime();
                $thresholdTime = time() - $threshold * 24 * 3600;
                if ($mTime < $thresholdTime) {
                    $this->log("Removing file: " . $file->getRealPath());
                    @unlink($file->getRealPath());
                }
            }
        }
    }
}
