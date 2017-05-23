<?php
declare(strict_types = 1);

namespace Zend\Firebase;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/samuel20miglia/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *
 */


/**
 * @author sviluppo
 *
 */
class FirebaseLogs
{

    /**
     *
     * @var Logger
     */
    private $logger;

    /**
     *
     * @var string
     */
    private $folderToStoreLog;

    /**
     * Format of datetime of logs
     *
     * @var string $dateFormatLog
     */
    private $dateFormatLog = "Y n j, g:i a";

    /**
     * DateTime of log filename
     *
     * @var string $dateFormatLogFilename
     */
    private static $dateFormatLogFilename;

    /**
     *
     * @param string $folderToStoreLog
     */
    public function __construct(string $folderToStoreLog)
    {
        $this->folderToStoreLog = $folderToStoreLog;

        $this->createLogger($folderToStoreLog);
    }

    /**
     * Write log of current event
     *
     * @param Logger $logger
     * @param array $eventData
     * @param mixed $event
     * @param string $path
     */
    public function writeEventLogs($eventData, $event, $path)
    {
        if (! empty($eventData) || null != $eventData) {
            $this->logger->addDebug("path: {$path}", [
                'DATA' => $eventData,
                'EVENT TYPE' => $event->getEventType()
            ]);
        } else {
            $this->logger->addDebug("path: {$path}", [
                'EVENT TYPE' => $event->getEventType()
            ]);
        }
    }

    /**
     *
     * Create logger instance for save stream log
     *
     * @param string $folderToStoreLog
     * @return Logger $logger
     */
    private function createLogger($folderToStoreLog)
    {
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
        // finally, create a formatter
        $formatter = new LineFormatter($output, $this->dateFormatLog);
        $this->dateFormatLogFilename = date("Y-m-d_H:i:s");
        // Create the logger
        $this->logger = new Logger('stream_logger');

        // Now add some handlers
        $stream = new StreamHandler(trim($folderToStoreLog) . $this->dateFormatLogFilename . ".log", Logger::DEBUG);

        $stream->setFormatter($formatter);
        $this->logger->pushHandler($stream);
        $this->logger->pushHandler(new FirePHPHandler());

        // You can now use your logger
        $this->logger->addInfo('Stream logger is ready...');
        return $this->logger;
    }
}
