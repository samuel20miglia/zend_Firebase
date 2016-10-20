<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use Interfaces\FirebaseInterface;
use GuzzleHttp\Client;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *
 */
class FirebaseInit implements FirebaseInterface
{

    /**
     * Default Timeout
     *
     * @var integer $timeout
     */
    private $timeout = 30;

    /**
     * __authentication object
     *
     * @var \ZendFirebase\Config\AuthSetup $auth
     */
    private $auth;

    /**
     * Create new Client
     *
     * @var GuzzleHttp\Client $client
     */
    private $client;

    /**
     * Responce from firebase
     *
     * @var string $response
     */
    private $response;

    /**
     * Type of _operation
     *
     * @var string $operation
     */
    private $operation;

    /**
     * Http server code
     *
     * @var http server code $status
     */
    private $status;

    /**
     * Create new Firebase _client object
     * Remember to install PHP CURL extention
     *
     * @param \ZendFirebase\Config\__authSetup $__auth
     */
    public function __construct(\ZendFirebase\Config\AuthSetup $auth)
    {
        $authMessage = 'Forget credential or is not an object.';
        $curlMessage = 'Extension CURL is not loaded or not installed.';
        
        // check if auth is null
        if (! is_object($auth) or null == $auth) {
            trigger_error($authMessage, E_USER_ERROR);
        }
        
        // check if extension is installed
        if (! extension_loaded('curl')) {
            trigger_error($curlMessage, E_USER_ERROR);
        }
        // set timeout
        $this->setTimeout(10);
        // store object into variable
        $this->auth = $auth;
        
        /*
         * create new client
         * set base uri
         * set timeout
         * set headers
         */
        $this->client = new Client([
            'base_uri' => $this->auth->get_baseURI(),
            'timeout' => $this->getTimeout(),
            'headers' => $this->getRequestHeaders()
        ]);
    }

    /**
     *
     * @return the $timeout
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * Default timeout is 10 seconds
     * is is not set switch to 30
     *
     * @param number $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Method for get array headers for Guzzle_client
     *
     * @throws \Exception
     * @return array
     */
    private function getRequestHeaders(): array
    {
        $headers = [];
        
        $headers['Accept'] = 'application/json';
        
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
     * @param unknown $path
     * @param array $options
     * @return string
     */
    private function getJsonPath($path, $options = [])
    {
        $options['auth'] = $this->auth->get_servertoken();
        
        $path = ltrim($path, '/');
        return $path . '.json?' . http_build_query($options);
    }

    /**
     * DELETE - Removing Data FROM FIREBASE
     *
     * @param string $path
     * @param array $data
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::delete()
     */
    public function delete($path, $options = [])
    {
        try {
            $_response = $this->client->delete($this->getJsonPath($path));
            $this->response = $_response->getReasonPhrase(); // OK
            $this->status = $_response->get_statusCode(); // 200
            $this->operation = 'DELETE';
        } catch (\Exception $e) {
            $this->response = null;
        }
    }

    /**
     * GET - Reading Data FROM FIREBASE
     *
     * @param string $path
     * @param array $data
     * @param array $options
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::get()
     */
    public function get($path, $options = [])
    {
        try {
            $_response = $this->client->get($this->getJsonPath($path));
            $this->response = $_response;
            $this->status = $_response->get_statusCode(); // 200
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

    /**
     * This method return the responce from firebase
     *
     * @return new FirebaseResponce readResponce() Method
     */
    public function responce()
    {
        $status = $this->status;
        $op = $this->operation;
        $data = $this->response;
        $resp = new FirebaseResponce($data, $op, $status);
        
        return $resp->readResponce();
    }

    /**
     * Remove object from memory
     */
    protected function __destruct()
    {
        unset($this);
    }
}
