<?php
namespace App\Libs;
class LogFile
{
    private static $logPath = '../storage/logs/';
    public static function writeLog($type = 'error', $message)
    {
        $fileName = storage_path('logs'.DIRECTORY_SEPARATOR.date('Y-m-d').'-'.$type.'.log');
        $openFile = fopen($fileName, 'a');
        $message = '['.date('Y-m-d H:i:s').'] '.env('APP_ENV', 'production').'.INFO: '.$message."\n";
        fwrite($openFile, $message);
        fclose($openFile);
    }

    public static function debugLog($type = 'error', $date = null)
    {
        if(empty($date)){
            $date = date('d-m-Y');
        }
        $fileName = storage_path('logs'.DIRECTORY_SEPARATOR.$type.'-'.date('Y-m-d').'.log');
        $openFile = fopen($fileName, 'w');
        $logFile = fread($openFile, filesize($fileName));
        die($logFile);
    }
}
?>