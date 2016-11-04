<?php
namespace ZendFirebase\Stream;

use InvalidArgumentException;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *
 */
class StreamEvent
{

    /**
     * Strng pattern END_OF_LINE
     *
     * @var string END_OF_LINE
     */
    const END_OF_LINE = "/\r\n|\n|\r/";

    /**
     * Raw data form stream
     *
     * @var string $data
     */
    private $data;

    /**
     * Type of event
     *
     * @var string $eventType
     */
    private $eventType;

    /**
     *
     * @param string $data
     * @param string $eventType
     */
    public function __construct($data = '', $eventType = 'message')
    {
        $this->data = $data;
        $this->eventType = $eventType;
    }

    /**
     *
     * @param $raw
     * @return StreamEvent $event
     */
    public static function parse($raw)
    {
        $event = new StreamEvent();
        $lines = self::splitEndOfStream($raw);

        foreach ($lines as $line) {
            $matches = '';
            $matched = preg_match('/(?P<name>[^:]*):?( ?(?P<value>.*))?/', $line, $matches);

            if (!$matched) {
                throw new InvalidArgumentException(sprintf('Invalid line %s', $line));
            }

            $name = $matches['name'];
            $value = $matches['value'];

            if ($name === '') {
                // ignore comments
                continue;
            }

            $event = self::parseEventData($event,$name, $value);
        }
        return $event;
    }
   
    /**
     * Return Object
     *
     * @param \ZendFirebase\Stream\StreamEvent $event
     * @param string $name
     * @param string $value
     * @return \ZendFirebase\Stream\StreamEvent
     */
    private static function parseEventData($event,$name, $value)
    {
       
        
        switch ($name) {
            case 'event':
                $event->eventType = $value;
                break;
            case 'data':
                $event->data = empty($event->data) ? $value : "$event->data\n$value";
                break;
        
            default:
                // The field is ignored.
                continue;
        }
        return $event;
    }


    /**
     * Find enf of stream
     *
     * @param mixed $raw
     * @return mixed
     */
    private static function splitEndOfStream($raw)
    {
        $lines = preg_split(self::END_OF_LINE, $raw);
        return $lines;
    }


    /**
     * All db changes
     *
     * @return string $this->data
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * Type of event
     *
     * @return string $this->eventType
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }
}
