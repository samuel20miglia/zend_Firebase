<?php
declare(strict_types = 1);
namespace ZendFirebase;

use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use phpDocumentor\Reflection\Types\Object_;

/**
 *
 * @author Davide Biasin
 *
 */
class FirebaseResponce
{

    /**
     *
     * @var Object_
     */
    private $responceData;

    /**
     *
     * @var String_
     */
    private $operation;

    /**
     *
     * @var Integer
     */
    private $status;

    /**
     *
     * @return the $responceData
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
     * @param object $responceData
     */
    protected function setResponceData($responceData)
    {
        $this->responceData = $responceData;
    }

    /**
     *
     * @param string $operation
     */
    protected function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     *
     * @param integer $status
     */
    protected function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     *
     * @param object $responceData
     * @param string $operation
     * @param integer $status
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
        // check validity of ResponceData
        // if (! is_object($this->getResponceData())) {
        // throw new \Exception("ResponceData parameter must be GuzzleHttp Object.
        // Received : " . gettype($this->getResponceData()) . " .");
        // }
        
        // check validity of Operation
        if (! is_string($this->getOperation()) || empty($this->getOperation())) {
            throw new \Exception("Operation parameter must be STRING and NOT EMPTY.
                Received : " . gettype($this->getOperation()) . " ({$this->getOperation()}).");
        }
        
        // check validity of Status
        if (! is_numeric($this->getStatus())) {
            throw new \Exception("Status parameter must be NUMERIC.
                Received : " . gettype($this->getStatus()) . " ({$this->getStatus()}).");
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
