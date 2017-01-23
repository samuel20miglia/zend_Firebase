<?php
declare(strict_types = 1);

namespace ZendFirebase;

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

    private $logger;
    
    private $folderToStoreLog;
    /**
     */
    public function __construct($folderToStoreLog)
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
    public function writeEventLogs($logger, $eventData, $event, $path)
    {
        if (! empty($eventData) || null != $eventData) {
            $logger->addDebug("path: {$path}", [
                'DATA' => $eventData,
                'EVENT TYPE' => $event->getEventType()
            ]);
        } else {
            $logger->addDebug("path: {$path}", [
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
        self::$dateFormatLogFilename = date("Y-m-d_H:i:s");
        // Create the logger
        $logger = new Logger('stream_logger');
    
        // Now add some handlers
        $stream = new StreamHandler(trim($folderToStoreLog) . self::$dateFormatLogFilename . ".log", Logger::DEBUG);
    
        $stream->setFormatter($formatter);
        $logger->pushHandler($stream);
        $logger->pushHandler(new FirePHPHandler());
    
        // You can now use your logger
        $logger->addInfo('Stream logger is ready...');
        return $logger;
    }
}
