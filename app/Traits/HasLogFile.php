<?php
/**
 * Created by: Naveed
 * Date: 7/21/2017
 * Time: 3:50 PM
 */

namespace App\Traits;


trait HasLogFile
{
    protected function log($content, $overwrite = false)
    {
        logContent($content, $this->logFile."-".date('Y-m-d').".log", $overwrite);
    }
}