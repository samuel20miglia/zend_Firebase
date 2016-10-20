<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;

/**
 *
 * @author Davide Biasin
 *        
 */
class FirebaseResponce
{

    /**
     *
     * @var GuzzleHttp Object
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
        return $this->responceData;
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
     *
     * @param
     *            string - Json $responceData
     * @param string $operation            
     * @param
     *            numeric string $status
     */
    public function __construct($responceData, $operation, $status)
    {
        // set class attributes
        $this->setResponceData($responceData);
        $this->setOperation($operation);
        $this->setStatus($status);
        
        // validate data received, otherwise throw new \Exception()
        $this->validateResponce();
    }

    /**
     * Method for get associative array with all data in responce
     *
     * @return array
     */
    public function readResponce(): array
    {
        // initialized array that will contain responce
        $responce = [];
        
        // put data that We need inside array
        $responce['operation'] = \strtoupper($this->getOperation());
        $responce['responcedata'] = $this->getResponceData();
        $responce['status'] = $this->getStatus();
        
        return $responce;
    }

    /**
     * Method for validate data arrives in _costruct.
     * If all data was correct skip function without returns.
     *
     * @throws \Exception
     */
    private function validateResponce()
    {
        // initialized variable that will contain subsequently the type of object attributes
        $type = '';
        
        // check validity of ResponceData
        if (! is_object($this->getResponceData())) {
            $type = gettype($this->getResponceData());
            throw new \Exception("ResponceData parameter must be GuzzleHttp Object. 
                Received : {$type} ({$this->getResponceData()}).");
        }
        
        // check validity of Operation
        if (! is_string($this->getOperation()) || empty($this->getOperation())) {
            $type = gettype($this->getOperation());
            throw new \Exception("Operation parameter must be STRING and NOT EMPTY. 
                Received : {$type} ({$this->getOperation()}).");
        }
        
        // check validity of Status
        if (! is_numeric($this->getStatus())) {
            $type = gettype($this->getStatus());
            throw new \Exception("Status parameter must be NUMERIC. 
                Received : {$type} ({$this->getStatus()}).");
        }
    }

    /**
     * Remove this current Object from memory
     */
    public function __destruct()
    {
        unset($this);
    }
}
