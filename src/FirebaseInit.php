<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use Interfaces\FirebaseInterface, GuzzleHttp\Client;
require 'Interfaces/FirebaseInterface.php';

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
    private $_timeout = 30;

    /**
     * __authentication object
     *
     * @var \ZendFirebase\Config\__authSetup $__auth
     */
    private $_auth;

    /**
     *
     * @var GuzzleHttp\_client $_client
     */
    private $_client;

    /**
     * Responce from firebase
     *
     * @var string $_response
     */
    private $_response;

    /**
     * Type of _operation
     *
     * @var string $_operation
     */
    private $_operation;

    /**
     * Http server code
     *
     * @var http server code $_status
     */
    private $_status;

    /**
     * Create new Firebase _client object
     * Remember to install PHP CURL extention
     *
     * @param \ZendFirebase\Config\__authSetup $__auth            
     */
    public function __construct(\ZendFirebase\Config\AuthSetup $_auth)
    {
        $auth = 'Forget credential or is not an object.';
        $curl = 'Extension CURL is not loaded or not installed.';
        if (! is_object($_auth) or null == $_auth) {
            trigger_error($auth, E_USER_ERROR);
        }
        
        if (! extension_loaded('curl')) {
            trigger_error($curl, E_USER_ERROR);
        }
        
        $this->setTimeout(10);
        $this->_auth = $_auth;
        
        $this->_client = new Client(
            [
            'base_uri' => $this->_auth->get_baseURI(),
            'timeout' => $this->getTimeout(),
            'headers' => $this->getRequestHeaders()
            ]
        );
    }

    /**
     *
     * @return the $timeout
     */
    public function getTimeout(): int
    {
        return $this->_timeout;
    }

    /**
     * Default timeout is 10 seconds
     * is is not set switch to 30
     *
     * @param number $timeout            
     */
    public function setTimeout($timeout)
    {
        $this->_timeout = $timeout;
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
        $options['_auth'] = $this->_auth->get_servertoken();
        
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
            $_response = $this->_client->delete($this->getJsonPath($path));
            $this->_response = $_response->getReasonPhrase(); // OK
            $this->_status = $_response->get_statusCode(); // 200
            $this->_operation = 'DELETE';
        } catch (\Exception $e) {
            $this->_response = null;
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
            $_response = $this->_client->get($this->getJsonPath($path));
            $this->_response = $_response;
            $this->_status = $_response->get_statusCode(); // 200
            $this->_operation = 'GET';
        } catch (\Exception $e) {
            $this->_response = null;
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
        $this->_response = $this->_client->patch(
            $this->getJsonPath($path), [
            'body' => \json_encode($data)
            ]
        );
        $this->_status = $this->_response->get_statusCode(); // 200
        $this->_operation = 'PATCH';
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
        $this->_response = $this->_client->post(
            $this->getJsonPath($path), [
            'body' => \json_encode($data)
            ]
        );
        $this->_status = $this->_response->get_statusCode(); // 200
        $this->_operation = 'POST';
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
        $this->_response = $this->_client->put(
            $this->getJsonPath($path), [
            'body' => \json_encode($data)
            ]
        );
        $this->_status = $this->_response->get_statusCode(); // 200
        $this->_operation = 'PUT';
    }

    /**
     * This method return the responce from firebase
     *
     * @return new FirebaseResponce readResponce() Method
     */
    public function responce()
    {
        $status = $this->_status;
        $op = $this->_operation;
        $data = $this->_response;
        $resp = new FirebaseResponce($data, $op, $status);
        
        return $resp->readResponce($data, $op, $status);
    }

    /**
     * Remove object from memory
     */
    protected function __destruct()
    {
        unset($this);
    }
}
