<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

class FirebaseResponce
{

    /**
     */
    public function __construct($responceData, $_operation)
    {
    }

    public function readResponce($responceData, $_operation): array
    {
        $responce = [];
        $responce['operation'] = \strtoupper($_operation);
        $responce['data'] = $responceData;
        
        return $responce;
    }

    /**
     */
    protected function __destruct()
    {
        unset($this);
    }
}
