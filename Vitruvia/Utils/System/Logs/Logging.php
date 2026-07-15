<?php

namespace Vitruvia\Utils\System\Logs;

class Logging
{
    protected string $logFile;

    public function __construct(string $logFile = "app.log")
    {
        $this->logFile = $logFile;
    }

    public function log(string $message, string $level = "info"): void
    {
        $line = sprintf("[%s] %s: %s%s", date("Y-m-d H:i:s"), strtoupper($level), $message, PHP_EOL);
        file_put_contents($this->logFile, $line, FILE_APPEND);
    }

    public function info(string $message): void
    {
        $this->log($message, "info");
    }

    public function error(string $message): void
    {
        $this->log($message, "error");
    }
}
