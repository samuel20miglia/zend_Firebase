<?php
use ZendFirebase\FirebaseResponce;

require_once 'src/FirebaseResponce.php';

/**
 * FirebaseResponce test case.
 *
 * @author Davide Biasin
 *        
 */
class FirebaseResponceTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var FirebaseResponce
     */
    protected $firebaseResponce;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // create instance of FirebaseResponce() object
        $this->firebaseResponce = new FirebaseResponce();
        
        $this->firebaseResponce->setFirebaseData([]);
        $this->firebaseResponce->setOperation('GET');
        $this->firebaseResponce->setStatus(200);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->firebaseResponce = null;
        
        parent::tearDown();
    }

    /**
     * Tests FirebaseResponce __construct()
     */
    public function testConstruct()
    {
        $this->firebaseResponce->__construct();
        
        $this->assertNotEquals(FirebaseResponce::class, $this->firebaseResponce);
    }

    /**
     * Tests FirebaseResponce->getFirebaseData()
     */
    public function testGetFirebaseData()
    {
        /* type array */
        $this->assertInternalType('array', $this->firebaseResponce->getFirebaseData());
    }

    /**
     * Tests FirebaseResponce->getOperation()
     */
    public function testGetOperation()
    {
        /* not empty */
        $this->assertNotEmpty($this->firebaseResponce->getOperation());
        
        /* type string */
        $this->assertInternalType('string', $this->firebaseResponce->getOperation());
    }

    /**
     * Tests FirebaseResponce->getStatus()
     */
    public function testGetStatus()
    {
        /* not empty */
        $this->assertNotEmpty($this->firebaseResponce->getStatus());
        
        /* type int */
        $this->assertInternalType('int', $this->firebaseResponce->getStatus());
    }

    /**
     * Tests FirebaseResponce->validateResponce()
     *
     * @expectedException TypeError
     *
     * @return void
     */
    public function testValidateResponce()
    {
        $this->firebaseResponce->setFirebaseData(null);
        $this->firebaseResponce->setOperation(null);
        $this->firebaseResponce->setStatus(null);
        
        // This function throwed new Exception if something not went well
        $this->firebaseResponce->validateResponce();
    }
}

