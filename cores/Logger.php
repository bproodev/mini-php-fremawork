<?php

namespace Core;

class Logger {

    private string $logFile;

    public function __construct(string $logFile='app.log') {
        $this->logFile = __DIR__ . '/../storage/logs/' . $logFile;
        if(!file_exists(dirname($this->logFile))){
            mkdir(dirname($this->logFile), 0775, true);
        }   
    }

    public function log(string $message, string $level = 'INFO') {
        $timestamp = date('Y-m-d H:i:s');
        $message = "[{$timestamp}] [{$level}] $message" . PHP_EOL;
        file_put_contents($this->logFile, $message, FILE_APPEND);
    }
}
