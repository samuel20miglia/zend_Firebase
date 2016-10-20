<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use Interfaces\FirebaseInterface, GuzzleHttp\Client;
require 'Interfaces/FirebaseInterface.php';

/**
 *
 * @author Ventimiglia Samuel
 * @author Biasin Davide
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

    private $auth;

    /**
     *
     * @var GuzzleHttp\Client
     */
    private $client;

    private $responce;

    /**
     */
    public function __construct(\ZendFirebase\Config\AuthSetup $auth)
    {
        if (! is_object($auth) or null == $auth) {
            trigger_error('Forget credential or is not an object.', E_USER_ERROR);
        }
        
        if (! extension_loaded('curl')) {
            trigger_error('Extension CURL is not loaded or not installed.', E_USER_ERROR);
        }
        
        $this->setTimeout(10);
        $this->auth = $auth;
        
        $guzzleClient = new Client([
            'base_uri' => $this->auth->getBaseUri(),
            'timeout' => $this->getTimeout(),
            'headers' => $this->getRequestHeaders()
        ]);
        
        $this->client = $guzzleClient;
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
     *
     * @param number $timeout            
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Method for get array headers for GuzzleClient
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
            throw new \Exception("The guzzle client headers must be an array.");
        }
        
        return $headers;
    }

    /**
     * Returns with the normalized JSON absolute path
     *
     * @param string $path
     *            Path
     * @param array $options
     *            Options
     * @return string
     */
    private function getJsonPath($path, $options = array())
    {
        $options['auth'] = $this->auth->getServerToken();
        
        $path = ltrim($path, '/');
        return $path . '.json?' . http_build_query($options);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::delete()
     */
    public function delete($path, array $data, $options = array())
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::get()
     */
    public function get($path, array $data, $options = array())
    {
        $this->client->get($this->getJsonPath($path), json_encode($data));
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::patch()
     */
    public function patch($path, array $data, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::post()
     */
    public function post($path, array $data, $options = array())
    {
        // return $this->client->request('POST', $this->getJsonPath($path), [
        // 'body' => \json_encode($data)
        // ]);
        return $this->client->post($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::put()
     */
    public function put($path, array $data, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     */
    public function __destruct()
    {
        
        // TODO - Insert your code here
    }

    private function writeData($path, $data, $options = array())
    {
        try {} catch (\Exception $e) {}
    }
}

