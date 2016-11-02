<?php
declare(strict_types = 1);
namespace ZendFirebase;

use Interfaces\FirebaseInterface;
use GuzzleHttp\Client;
use ZendFirebase\Stream\StreamClient;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\LineFormatter;
require 'Interfaces/FirebaseInterface.php';
require 'Stream/StreamClient.php';

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *
 */

/**
 * This class do rest operations to firebase server
 *
 * @author ghostbyte
 * @package ZendFirebase
 */
class Firebase extends FirebaseResponce implements FirebaseInterface
{

    /**
     * Default Timeout
     *
     * @var integer $timeout
     */
    private $timeout = 30;

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
     * Authentication object
     *
     * @var $auth
     */
    private $auth;

    /**
     * Create new Client
     *
     * @var $client
     */
    private $client;

    /**
     * Responce from firebase
     *
     * @var mixed $response
     */
    private $response;

    /**
     * Create new Firebase client object
     * Remember to install PHP CURL extention
     *
     * @param Config\FirebaseAuth $auth
     */
    public function __construct(\ZendFirebase\Config\FirebaseAuth $auth)
    {
        $authMessage = 'Forget credential or is not an object.';
        $curlMessage = 'Extension CURL is not loaded or not installed.';
        
        // check if auth is null
        if (! is_object($auth) || null == $auth) {
            trigger_error($authMessage, E_USER_ERROR);
        }
        
        // check if extension is installed
        if (! extension_loaded('curl')) {
            trigger_error($curlMessage, E_USER_ERROR);
        }
        
        // store object into variable
        $this->auth = $auth;
        
        /* create new client */
        $this->client = new Client([
            'base_uri' => $this->auth->getBaseURI(),
            'timeout' => $this->getTimeout(),
            'headers' => $this->getRequestHeaders()
        ]);
    }

    /**
     * Return Integer of Timeout
     * default 30 setted 10
     *
     * @return integer $timeout
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Default timeout is 10 seconds
     * is is not set switch to 30
     *
     * @param integer $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Method for get array headers for Guzzle client
     *
     * @throws \Exception
     * @return array
     */
    private function getRequestHeaders(): array
    {
        $headers = [];
        $headers['stream'] = true;
        $headers['Accept'] = 'application/json';
        $headers['Content-Type'] = 'application/json';
        
        // check if header is an array
        if (! is_array($headers)) {
            $str = "The guzzle client headers must be an array.";
            throw new \Exception($str);
        }
        
        return $headers;
    }

    /**
     * Returns with the normalized JSON absolute path
     *
     * @param string $path
     * @param array $options
     * @return string $path
     */
    private function getJsonPath($path, $options = []): string
    {
        $options['auth'] = $this->auth->getServertoken();
        
        $path = ltrim($path, '/');
        return $path . '.json?' . http_build_query($options);
    }

    /**
     * DELETE - Removing Data FROM FIREBASE
     *
     * @param string $path
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::delete()
     */
    public function delete($path, $options = [])
    {
        try {
            
            $this->writeRequest('delete', $this->getJsonPath($path), '');
           
        } catch (\Exception $e) {
            $this->response = null;
        }
    }

    /**
     * GET - Reading Data FROM FIREBASE
     *
     * @param string $path
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::get()
     */
    public function get($path, $options = [])
    {
        try {
            
            $this->writeRequest('get', $this->getJsonPath($path), '');
        } catch (\Exception $e) {
            $this->response = null;
        }
    }

    /**
     * PATCH - Updating Data TO FIREBASE
     *
     * @param string $path
     * @param array $data
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::patch()
     */
    public function patch($path, array $data, $options = [])
    {
        $this->writeRequest('patch', $this->getJsonPath($path), $data);
        
    }

    /**
     * POST - Pushing Data TO FIREBASE
     *
     * @param string $path
     * @param array $data
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::post()
     */
    public function post($path, array $data, $options = [])
    {
        
        $this->writeRequest('post', $this->getJsonPath($path), $data);

    }

    /**
     * PUT - Writing Data TO FIREBASE
     *
     * @param string $path
     * @param array $data
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::put()
     */
    public function put($path, array $data, $options = [])
    {
        $this->writeRequest('put', $this->getJsonPath($path), $data);
        
    }

    /**
     * Method to send request
     *
     * @param string $op
     * @param string $path
     * @param mixed $data
     */
    private function writeRequest($op, $path, $data)
    {
        $operation = \strtolower($op);
        
        switch ($operation) {
            case 'get':
                
                $response = $this->client->{$operation}($path);
                $this->response = $response->getBody()->getContents();
                
                $this->setDataFromOperation('get', $response->getStatusCode());
                break;
            case 'delete':
                $response = $this->client->{$operation}($path);
                $this->response = $response->getReasonPhrase(); // OK
                $this->setDataFromOperation('get', $response->getStatusCode());
                break;
            
            default:
                $this->response = $this->client->{$operation}($path, [
                    'body' => $data
                ]);
                
                $this->setDataFromOperation($op, $this->response->getStatusCode());
                break;
        }
        
       
    }

    /**
     * This function set variables after operation
     *
     * @param string $operation
     * @param mixed $status
     */
    private function setDataFromOperation($operation, $status)
    {
        $oP = \strtoupper($operation);
        
        $this->status = $status; // 200
        $this->operation = $oP;
    }

    /**
     * Start stream with server and write log in choised folder
     *
     * @param string $path
     * @param string $folderToStoreLog
     * @param integer $requestDelay
     * @example $requestDelay = 3000 -> 3 seconds between get request
     */
    public function startStream($path, $folderToStoreLog, $requestDelay = 5000)
    {
        $url = $this->auth->getBaseURI() . $this->getJsonPath($path);
        
        $client = new StreamClient($url, $requestDelay);
        
        // returns generator
        $events = $client->getEvents();
        
        /* search / in string */
        $folderName = substr(strrchr(trim($folderToStoreLog), "/"), 1);
        /* if not exsits add on path+/ */
        $folderName = empty($folderName) ? $folderToStoreLog . '/' : $folderToStoreLog;
        // call method for create instance of logger
        $logger = $this->createLogger($folderName);
        
        // blocks until new event arrive
        foreach ($events as $event) {
            // decode json data arrived to php array
            $eventData = json_decode($event->getData(), true);
            
            // pass event to callback function
            print_r($eventData);
            print_r("EVENT TYPE: " . $event->getEventType() . PHP_EOL . PHP_EOL);
            
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
    }

    /**
     *
     * Create logger instance for save stream log
     *
     * @param string $folderToStoreLog
     * @return Monolog\Logger $logger
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

    /**
     * This method return the responce from firebase
     *
     * @example set and validate data passed
     */
    public function makeResponce()
    {
        $jsonData = [];
        if ($this->operation === 'GET') {
            $jsonData = json_decode($this->response, true);
        } else {
            $jsonData[] = 'success';
        }
        
        /* Set data after operations */
        $this->setOperation($this->operation);
        $this->setStatus($this->status);
        $this->setFirebaseData($jsonData);
        $this->validateResponce();
    }

    /**
     * Remove object from memory
     */
    public function __destruct()
    {}
}
