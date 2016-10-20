<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;

class FirebaseResponce
{

    /**
     *
     * @var String_ ( Json )
     */
    private $responceData;

    /**
     *
     * @var String_
     */
    private $operation;

    /**
     *
     * @var Integer or NumericString
     */
    private $status;

    /**
     *
     * @return the $responce
     */
    public function getResponceData()
    {
        return $this->responce;
    }

    /**
     *
     * @return the $operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

    /**
     *
     * @return the $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *
     * @param field_type $responce            
     */
    protected function setResponceData($responceData)
    {
        $this->responceData = $responceData;
    }

    /**
     *
     * @param field_type $operation            
     */
    protected function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     *
     * @param field_type $status            
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     */
    public function __construct($responceData, $operation, $status)
    {
        $this->setResponceData($responceData);
        $this->setOperation($operation);
        $this->setStatus($status);
    }

    public function readResponce($responceData, $operation): array
    {
        // $responce = [];
        // $responce['operation'] = \strtoupper($operation);
        // $responce['status'];
        $responce = [];
        $responce['operation'] = \strtoupper($operation);
        $responce['data'] = $responceData;
        
        // return $responce;
    }

    private function validateResponce()
    {}

    /**
     */
    protected function __destruct()
    {
        unset($this);
    }
}

