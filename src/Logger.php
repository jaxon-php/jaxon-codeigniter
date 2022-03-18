<?php

namespace Jaxon\CI;

use Psr\Log\LoggerInterface;
use Psr\Log\AbstractLogger;
use Psr\Log\LogLevel;
use Psr\Log\InvalidArgumentException;

use function ltrim;
use function json_encode;
use function log_message;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function log($sLevel, $sMessage, array $aContext = [])
    {
        $sMessage = rtrim((string)$sMessage, ' .') . '. ' . json_encode($aContext);

        // Map the PSR-3 severity to CodeIgniter log level.
        switch($sLevel)
        {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                log_message("error", $sMessage);
                break;
            case LogLevel::WARNING:
            case LogLevel::DEBUG:
                log_message("debug", $sMessage);
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
                log_message("info", $sMessage);
                break;
            default:
                throw new InvalidArgumentException("Unknown severity level");
        }
    }
}
