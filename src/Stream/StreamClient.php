<?php
namespace Zend\Firebase\Stream;

use GuzzleHttp;
use RuntimeException;

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
 * This class create an object of Client
 *
 * @author ghostbyte
 * @package ZendFirebase
 * @since 2016-10-28
 *
 */
class StreamClient
{

    /**
     * Stream pattern END_OF_MESSAGE
     *
     * @var string
     */
    const END_OF_MESSAGE = "/\r\n\r\n|\n\n|\r\r/";

    /**
     * Client for send request
     *
     * @var GuzzleHttp\Client $client
     */
    private $client;

    /**
     * Responce object from rest
     *
     * @var GuzzleHttp\Psr7\Response $response
     */
    private $response;

    /**
     * Request url to send request
     *
     * @var string $url
     */
    private $url;

    /**
     * Request options to add to url
     *
     * @var string
     */
    private $options = [];

    /**
     * Last received message id
     *
     * @var string $lastMessageId
     */
    private $lastMessageId;

    /**
     * Reconnection time in milliseconds
     *
     * @var integer $retry
     */
    private $retry = 3000;

    /**
     * Constructor
     *
     * @param string $url
     * @param integer $requestDelay
     * @throws InvaliArgumentException
     */
    public function __construct($url, $requestDelay, $options)
    {
        $this->url = $url;
        $this->retry = $requestDelay;
        $this->options = $options;

        if (empty($this->url)) {
            throw new \InvalidArgumentException('Error: url empty...');
        }
        $this->createClientObject();
        $this->connect();
    }

    /**
     * Create client
     */
    private function createClientObject()
    {
        $this->client = new GuzzleHttp\Client([
            'headers' => [
                'Accept' => 'text/event-stream',
                'Cache-Control' => 'no-cache',
                'allow_redirects' => true
            ],

            'base_uri' => $this->url,
        ]);

        $this->connect();
    }

    /**
     *
     * @return string $lastMessageId
     */
    public function getLastMessageId(): string
    {
        return $this->lastMessageId;
    }

    /**
     *
     * @param string $lastMessageId
     */
    public function setLastMessageId($lastMessageId)
    {
        $this->lastMessageId = $lastMessageId;
    }

    /**
     * Connect to firebase server
     *
     * @throws RuntimeException
     */
    private function connect()
    {

        $this->sendRequest();

        if ($this->response->getStatusCode() == 204) {
            throw new RuntimeException('Error: Server forbid connection retry by responding 204 status code.');
        }
    }

    /**
     * Create url with or without query options
     *
     * @return string
     */
    private function createUrl(): string
    {
        return $this->url . $this->options;
    }

    /**
     * Send Request
     */
    private function sendRequest()
    {
        try {
            $headers = [];
            if ($this->lastMessageId) {
                $headers['Last-Event-ID'] = $this->lastMessageId;
            }

            $this->response = $this->client->request('GET', $this->createUrl(), [
            'stream' => true,
            'headers' => $headers,
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            die((string)$e->getResponse()->getBody());
        }
    }


    /**
     * Returns generator that yields new event when it's available on stream.
     */
    public function getEvents()
    {
        /* initialize empty buffer */
        $buffer = '';

        /* bring body of response */
        $body = $this->response->getBody();

        /* infinte loop */
        while (true) {
            /* if server close connection - try to reconnect */
            if ($body->eof()) {
                /* wait retry period before reconnection */
                sleep($this->retry / 1000);

                /* reconnect */
                $this->connect();

                /* clear buffer since there is no sense in partial message */
                $buffer = '';
            }
            /* start read into stream */
            $buffer .= $body->read(1);

            if (preg_match(self::END_OF_MESSAGE, $buffer)) {
                $parts = preg_split(self::END_OF_MESSAGE, $buffer, 2);

                $rawMessage = $parts[0];
                $remaining = $parts[1];

                $buffer = $remaining;

                /**
                 * Save event into StreamEvent
                 *
                 * @var StreamEvent $event
                 */
                $event = StreamEvent::parse($rawMessage);

                yield $event;
            }
        }
    }
}
