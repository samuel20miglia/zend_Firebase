<?php
declare(strict_types = 1);
namespace ZendFirebase;

/**
 *
 * @author Davide Biasin
 *
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
    {}

    /**
     * Remove this current Object from memory
     */
    public function __destruct()
    {
        unset($this);
    }

    /**
     * Format to array the responce
     *
     *@return array $firebaseData
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
     *Set data from firebase api
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

        /* check validity of Operation */
        if (! is_string($this->getOperation()) || empty($this->getOperation())) {
            throw new \Exception(
                "Operation parameter must be STRING and NOT EMPTY. Received : " . gettype($this->getOperation()) .
                     " ({$this->getOperation()}).");
        }

        /* check validity of Status */
        if (! is_numeric($this->getStatus())) {
            throw new \Exception(
                "Status parameter must be NUMERIC. Received : " . gettype($this->getStatus()) .
                     " ({$this->getStatus()}).");
        }

        /* check validity of FirebaseData */
        if (! is_array($this->getFirebaseData()) && ! empty($this->getFirebaseData())) {
            throw new \Exception(
                "FirebaseData parameter must be ARRAY. Received : " . gettype($this->getFirebaseData()) . ".");
        }
    }
}
