<?php
namespace ZendFirebase\Exception;

/**
 *
 * @author sviluppo
 *
 */
class ZendFirebaseException
{

    private $error;

    private $message;

    /**
     *
     * @param unknown $error
     * @param unknown $message
     */
    public function __construct($error, $message)
    {
        $this->error = $error;
        $this->message = $message;
    }

    /**
     * remove object from memory
     */
    public function __destruct()
    {
        unset($this);
    }
}
