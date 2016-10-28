<?php
declare(strict_types = 1);
namespace ZendFirebase;

use Interfaces\FirebaseInterface;
use GuzzleHttp\Client;
use ZendFirebase\Stream\StreamClient;

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
class Firebase extends FirebaseResponce implements FirebaseInterface
{

    /**
     * Default Timeout
     *
     * @var integer $timeout
     */
    private $timeout = 30;

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
     * @param \ZendFirebase\Config\AuthSetup $auth
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
        
        /*
         * create new client
         * set base_uri
         * set timeout
         * set headers
         */
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
            $response = $this->client->delete($this->getJsonPath($path));
            $this->response = $response->getReasonPhrase(); // OK
            $this->status = $response->getStatusCode(); // 200
            $this->operation = 'DELETE';
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
            $response = $this->client->get($this->getJsonPath($path));
            $this->response = $response->getBody()->getContents();
            $this->status = $response->getStatusCode(); // 200
            $this->operation = 'GET';
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
        $this->response = $this->client->patch($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
        $this->status = $this->response->getStatusCode(); // 200
        $this->operation = 'PATCH';
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
        $this->response = $this->client->post($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
        $this->status = $this->response->getStatusCode(); // 200
        $this->operation = 'POST';
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
        $this->response = $this->client->put($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
        $this->status = $this->response->getStatusCode(); // 200
        $this->operation = 'PUT';
    }
    
    public function startStream($path,$typeofResponce = 'object')
    {
        $url = $this->auth->getBaseURI().$this->getJsonPath($path);
        
        
        $client = new StreamClient($url);
        
        // returns generator
        $events = $client->getEvents();
        
        // blocks until new event arrive
        foreach ($events as $event) {
            // pass event to callback function
            print_r($event);
        }
        
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
    {
        unset($this);
    }
}
