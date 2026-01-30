<?php

namespace App\Common;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Logger implements LoggerInterface
{
    use LoggerTrait;

    private string $logLevel;
    private array $levels = [
        'debug' => 0,
        'info' => 1,
        'notice' => 2,
        'warning' => 3,
        'error' => 4,
        'critical' => 5,
        'alert' => 6,
        'emergency' => 7,
    ];

    public function __construct()
    {
        $config = require __DIR__ . '/../../config/app.php';
        $this->logLevel = strtolower($config['log_level'] ?? 'debug');
    }

    public function log($level, $message, array $context = []): void
    {
        $levelLower = strtolower($level);
        
        if (!isset($this->levels[$levelLower])) {
            return;
        }

        if ($this->levels[$levelLower] < $this->levels[$this->logLevel]) {
            return;
        }

        $timestamp = date('Y-m-d H:i:s');
        $levelUpper = strtoupper($level);
        $logMessage = "[{$timestamp}] [{$levelUpper}] {$message}";
        
        if (!empty($context)) {
            $logMessage .= ' ' . json_encode($context, JSON_UNESCAPED_UNICODE);
        }

        // In produzione potresti scrivere su file, per ora solo error_log
        error_log($logMessage);
    }
}
