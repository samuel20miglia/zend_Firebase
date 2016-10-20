<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use Interfaces\FirebaseInterface, GuzzleHttp\Client;
require 'Interfaces/FirebaseInterface.php';

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 * @link https://github.com/Samuel18/zend_Firebase for the canonical source repository
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *         
 *          Redistribution and use in source and binary forms, with or without
 *          modification, are permitted provided that the following conditions are met:
 *         
 *          Redistributions of source code must retain the above copyright notice, this
 *          list of conditions and the following disclaimer.
 *         
 *          Redistributions in binary form must reproduce the above copyright notice,
 *          this list of conditions and the following disclaimer in the documentation
 *          and/or other materials provided with the distribution.
 *         
 *          Neither the name of the copyright holder nor the names of its
 *          contributors may be used to endorse or promote products derived from
 *          this software without specific prior written permission.
 *         
 *          THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 *          AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 *          IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *          DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 *          FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 *          DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 *          SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 *          CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 *          OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 *          OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
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

    private $client;

    private $responce;

    /**
     * Create new Firebase Client object
     * Remember to install PHP CURL extention
     *
     * @param \ZendFirebase\Config\AuthSetup $auth            
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
            'timeout' => $this->getTimeout()
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

    private function getRequestHeaders(): array
    {
        $headers = [];
        $headers['headers'] = [
            'Accept' => 'application/json'
        ];
        
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
    public function delete($path, array $data, $options = array())
    {}

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
    public function get($path, $options = array())
    {
        try {
            $responce = $this->client->get($this->getJsonPath($path));
            $return = $responce->getBody();
        } catch (\Exception $e) {
            $return = null;
        }
        
        return $return;
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
    public function patch($path, array $data, $options = array())
    {
        return $this->client->patch($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
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
    public function post($path, array $data, $options = array())
    {
        return $this->client->post($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
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
    public function put($path, array $data, $options = array())
    {
        return $this->client->put($this->getJsonPath($path), [
            'body' => \json_encode($data)
        ]);
    }

    /**
     * Remove object from memory
     */
    public function __destruct()
    {
        unset($this);
    }

    private function writeData($path, $data, $options = array())
    {
        try {} catch (\Exception $e) {}
    }

    private function setHeaderToGuzzleClient($headers)
    {
        // check if header is an array
        if (! is_array($headers)) {
            throw new \Exception("The guzzle client headers must be an array.");
        }
        
        // check if array passed contains key 'headers'
        if (! array_key_exists('headers', $headers)) {
            throw new \Exception("Headers array must have a key named 'headers'.");
        }
    }
}

