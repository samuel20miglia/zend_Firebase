<?php
namespace ZendFirebase\Stream;

use GuzzleHttp;
use RuntimeException;

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
    public function __construct($url, $requestDelay)
    {
        $this->url = $url;
        $this->retry = $requestDelay;

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
            ]
        ]);
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
        $headers = [];
        if ($this->lastMessageId) {
            $headers['Last-Event-ID'] = $this->lastMessageId;
        }

        $this->response = $this->client->request('GET', $this->url, [
            'stream' => true,
            'headers' => $headers
        ]);

        if ($this->response->getStatusCode() == 204) {
            throw new RuntimeException('Error: Server forbid connection retry by responding 204 status code.');
        }
    }

    /**
     * Returns generator that yields new event when it's available on stream.
     *
     * @return \Generator
     */
    public function getEvents()
    {
        /* initialize empty buffer */
        $buffer = '';

        /* bring body of response */
        $body = $this->response->getBody();

        $buffer = $this->infiniteLoop($buffer, $body, $parts, $rawMessage, $remaining, $event);
    }

    /**
     * Create infinite loop
     *
     * @param unknown $buffer
     * @param unknown $body
     * @param unknown $parts
     * @param unknown $rawMessage
     * @param unknown $remaining
     * @param unknown $event
     * @return unknown|Generator
     */
    private function infiniteLoop($buffer, $body, $parts, $rawMessage, $remaining, $event): string
    {
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
                 * @var StreamEvent
                 * @return StreamEvent $event
                 */
                $event = StreamEvent::parse($rawMessage);

                yield $event;
            }
        }
        return $buffer;
    }
}
