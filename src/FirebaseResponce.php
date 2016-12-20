<?php
declare(strict_types = 1);
namespace ZendFirebase;

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
 *
 * @author Davide Biasin
 * @package ZendFirebase
 */
class FirebaseResponce
{

    /**
     * Data from Firebase
     *
     * @var array $firebaseData
     */
    private $firebaseData;

    /**
     * Type of operation
     *
     * @var string $operation
     */
    protected $operation;

    /**
     * Http server code
     *
     * @var integer $status
     */
    protected $status;

    /**
     * Constructior method
     */
    public function __construct()
    {
    }

    /**
     * Remove this current Object from memory
     */
    public function __destruct()
    {
    }

    /**
     * Format to array the responce
     *
     * @return array $firebaseData
     */
    public function getFirebaseData(): array
    {
        return $this->firebaseData;
    }

    /**
     * Type of Operation
     *
     * @return string $operation
     */
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * Status from http server
     *
     * @return integer $status
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Set data from firebase api
     *
     * @param array $firebaseData
     */
    public function setFirebaseData($firebaseData)
    {
        $this->firebaseData = $firebaseData;
    }

    /**
     * Set type of operation
     *
     * @param string $operation
     */
    public function setOperation($operation)
    {
        $this->operation = $operation;
    }

    /**
     * Set status responce
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Method for validate data arrives in _costruct.
     * If all data was correct skip function without returns.
     *
     * @throws \Exception
     */
    public function validateResponce()
    {
        try {
            /* check validity of Operation */
            $this->validateOperation();
            
            /* check validity of Status */
            $this->validateStatus();
            
            /* check validity of FirebaseData */
            $this->validateData();
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Validate type of data receved
     *
     * @throws \Exception
     */
    private function validateOperation()
    {
        if (! is_string($this->getOperation())) {
            $getOperation = "Operation parameter must be STRING and NOT EMPTY. Received : ";
            $getOperation .= gettype($this->getOperation()) . " ({$this->getOperation()}).";
            
            throw new \Exception($getOperation);
        }
    }

    /**
     * Validate type of data receved
     *
     * @throws \Exception
     */
    private function validateStatus()
    {
        if (! is_numeric($this->getStatus())) {
            $getStatus = "Status parameter must be NUMERIC. Received : ";
            $getStatus .= gettype($this->getStatus()) . " ({$this->getStatus()}).";
            
            throw new \Exception($getStatus);
        }
    }

    /**
     * Validate type of data receved
     *
     * @throws \Exception
     */
    private function validateData()
    {
        if (! is_array($this->getFirebaseData())) {
            $gettype = "FirebaseData parameter must be ARRAY. Received : " . gettype($this->getFirebaseData()) . ".";
            throw new \Exception($gettype);
        }
    }
    
    /**
     * Validate type of json receved
     *
     * @return string|false
     */
    protected function validateJson()
    {
        switch (json_last_error()) {
            case JSON_ERROR_NONE:
                $jsonValidator =  false;
                break;
            case JSON_ERROR_DEPTH:
                $jsonValidator =  ' - Maximum stack depth exceeded';
                break;
            case JSON_ERROR_STATE_MISMATCH:
                $jsonValidator =  ' - Underflow or the modes mismatch';
                break;
            case JSON_ERROR_CTRL_CHAR:
                $jsonValidator =  ' - Unexpected control character found';
                break;
            case JSON_ERROR_SYNTAX:
                $jsonValidator =  ' - Syntax error, malformed JSON';
                break;
            case JSON_ERROR_UTF8:
                $jsonValidator =  ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
            default:
                $jsonValidator =  ' - Unknown error';
                break;
        }
        
        return $jsonValidator;
    }
}
