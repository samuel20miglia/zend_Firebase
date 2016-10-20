<?php
namespace ZendFirebase\Exception;

/**
 *
 * @author sviluppo
 *
 */
class ZendFirebaseException
{

    /**
     *
     * @param
     *            $error
     * @param
     *            $message
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
