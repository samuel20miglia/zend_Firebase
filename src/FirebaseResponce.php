<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

class FirebaseResponce
{

    /**
     */
    public function __construct($responceData, $operation)
    {}

    public function readResponce($responceData, $operation): array
    {
        $responce = [];
        $responce['operation'] = \strtoupper($operation);
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

