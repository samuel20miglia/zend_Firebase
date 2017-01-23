<?php
declare(strict_types = 1);
namespace ZendFirebase;

use ZendFirebase\Interfaces\FirebaseInterface;
use GuzzleHttp\Client;
use ZendFirebase\Stream\StreamClient;
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
     * @var Config\FirebaseAuth $auth
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
     * Last Auto-Increment saved from post operation
     *
     * @var string $lastIdStored
     */
    protected $lastIdStored = '';

    /**
     * Create new Firebase client object
     * Remember to install PHP CURL extention
     *
     * @param Config\FirebaseAuth $auth
     */
    public function __construct(\ZendFirebase\Authentication\FirebaseAuth $auth)
    {
        $this->checkDipendenties($auth);
        
        // store object into variable
        $this->auth = $auth;
        
        $this->guzzeClientInit();
    }

    /**
     * Create new guzzle client
     */
    private function guzzeClientInit()
    {
        
        /* create new client */
        $this->client = new Client([
            'base_uri' => $this->auth->getBaseURI(),
            'timeout' => $this->getTimeout(),
            'headers' => $this->getRequestHeaders()
        ]);
    }

    /**
     * Controll of all dipendenties
     *
     * @param \ZendFirebase\Config\FirebaseAuth $auth
     */
    private function checkDipendenties($auth)
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
     * Return string of LastIdStored generated after post command
     *
     * @return string $lastIdStored
     */
    public function getLastIdStored(): string
    {
        return $this->lastIdStored;
    }

    /**
     * Set string of LastIdStored generated after post command
     *
     * @param string $lastIdStored
     */
    public function setLastIdStored($lastIdStored)
    {
        $this->lastIdStored = $lastIdStored;
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
        /* autentication token */
        $auth = $this->auth->getServertoken();
        /* returns the data in a human-readable format */
        $options['print'] = 'pretty';
        
        foreach ($options as $opt => $optVal) {
            if (\is_string($optVal)) {
                $options[$opt] = '"' . $optVal . '"';
                \var_dump($optVal);
            }
        }
        
        $path = ltrim($path, '/');
        
        return $path . '.json?auth=' . $auth . '&' . http_build_query($options) . '';
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
        $this->writeRequest('delete', $this->getJsonPath($path, $options), '');
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
        $this->writeRequest('get', $this->getJsonPath($path, $options), '');
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
        $this->writeRequest('patch', $this->getJsonPath($path, $options), $data);
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
        $this->writeRequest('post', $this->getJsonPath($path, $options), $data);
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
        $this->writeRequest('put', $this->getJsonPath($path, $options), $data);
    }

    /**
     * READ RULES - Retrieve firebase rules
     *
     * @param string $path
     */
    public function getRules($path)
    {
        $this->writeRequest('get', $this->getJsonPath($path, []), []);
    }
    
    /**
     * WRITE RULES - Retrieve firebase rules
     *
     * @param string $path
     */
    public function writeRules($path,array $data)
    {
        $this->writeRequest('put', $this->getJsonPath($path, []), $data);
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
                $bodyResponse = $response->getBody()->getContents();
                $this->setDataFromOperation('get', $response->getStatusCode());
                break;
            case 'delete':
                $response = $this->client->{$operation}($path);
                $bodyResponse = $response->getReasonPhrase(); // OK
                $this->setDataFromOperation('get', $response->getStatusCode());
                break;
            case 'post':
                $bodyResponse = $this->client->{$operation}($path, [
                    'body' => \json_encode($data)
                ]);
                
                // save auto-increment id created from Firebase after post operation
                $this->setLastIdStored(json_decode($bodyResponse->getBody()
                    ->getContents(), true)['name']);
                
                $this->setDataFromOperation($op, $bodyResponse->getStatusCode());
                break;
            
            default:
                $bodyResponse = $this->client->{$operation}($path, [
                    'body' => \json_encode($data)
                ]);
                
                $this->setDataFromOperation($op, $bodyResponse->getStatusCode());
                break;
        }
        
        $this->response = $bodyResponse;
        $this->makeResponce();
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
     * @param string $callback
     * @param array $options
     * @param boolean $print
     * @example $requestDelay = 3000 -> 3 seconds between get request
     */
    public function startStream($path, $folderToStoreLog, $callback, $requestDelay = 5000, $options = [], $print = true)
    {
        $url = $this->auth->getBaseURI();
        
        $client = new StreamClient($url, $requestDelay, $this->getJsonPath($path, $options));
        
        // returns generator
        $events = $client->getEvents();
        
        // call method for create instance of logger
        $logger = $this->createLogger($this->formatFolderName($folderToStoreLog));
        
        // blocks until new event arrive
        foreach ($events as $event) {
            // decode json data arrived to php array
            $eventData = \json_decode($event->getData(), true);
            
            // callback to return
            $callback($eventData, $event->getEventType());
            
            if ($print) {
                // anyway print data in output
                $this->printEventData($eventData, $event);
            }
            
            // write logs
            $this->writeEventLogs($logger, $eventData, $event, $path);
        }
    }

    /**
     * Print on output datas
     *
     * @param mixed $eventData
     * @param mixed $event
     */
    private function printEventData($eventData, $event)
    {
        // pass event to callback function
        print_r($eventData);
        print_r("EVENT TYPE: " . $event->getEventType() . PHP_EOL . PHP_EOL);
    }

    /**
     * Write log of current event
     *
     * @param Logger $logger
     * @param array $eventData
     * @param mixed $event
     * @param string $path
     */
    private function writeEventLogs($logger, $eventData, $event, $path)
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
     * Format folder name
     *
     * @param string $folderToStoreLog
     * @return string $folderName
     */
    private function formatFolderName($folderToStoreLog): string
    {
        /* search / in string */
        $folderName = substr(strrchr(trim($folderToStoreLog), "/"), 1);
        /* if not exsits add on path+/ */
        $folderName = empty($folderName) ? $folderToStoreLog . '/' : $folderToStoreLog;
        
        return $folderName;
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

    /**
     * This method return the responce from firebase
     *
     * @example set and validate data passed
     */
    private function makeResponce()
    {
        $jsonData = [];
        if ($this->operation === 'GET') {
            $jsonData = json_decode($this->response, true);
            
            if ($this->validateJson() !== false) {
                $jsonData[] = $this->validateJson();
            }
            if (empty($jsonData)) {
                $jsonData[] = '204 No Content';
            }
        } else {
            $jsonData[] = 'Success';
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
    {
    }
}
