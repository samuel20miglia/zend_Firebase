<?php
namespace Zend\FirebaseTest;

use Zend\Firebase\Firebase;
use Zend\Firebase\Authentication\FirebaseAuth;
use PHPUnit\Framework\TestCase;

require_once 'src/Firebase.php';
require_once 'src/Authentication/FirebaseAuth.php';

/**
 * Firebase test case.
 */
class FirebaseTest extends TestCase
{

    /**
     *
     * @var FirebaseInit
     */
    private $firebaseInit;

    // --- set up your own database here
    protected $baseUri = 'https://zendfirebase.firebaseio.com/';

    protected $token = 'YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4';

    private $auth;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        $this->auth = new FirebaseAuth();

        $this->auth->setServertoken($this->token);
        $this->auth->setBaseURI($this->baseUri);
        // Auto-generated FirebaseInitTest::setUp()
        $this->firebaseInit = new Firebase($this->auth);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated FirebaseInitTest::tearDown()
        $this->firebaseInit = null;

        parent::tearDown();
    }

    /**
     * Tests FirebaseInit->__construct()
     */
    public function testConstruct()
    {

        $testAuth = new FirebaseAuth();
        $testAuth->setServertoken($this->token);
        $testAuth->setBaseURI($this->baseUri);
        $this->firebaseInit->__construct($this->auth);
        $this->assertEquals($testAuth, $this->auth);

    }

    /**
     * Tests FirebaseInit->setTimeout()
     * @depends testConstruct
     */
    public function testSetTimeout()
    {
        $timeout = 10;

        $this->firebaseInit->setTimeout($timeout);

        /* not empty */
        $this->assertNotEmpty($this->firebaseInit->getTimeout());

        /* type int */
        $this->assertInternalType('int', $this->firebaseInit->getTimeout());
    }

    /**
     * Test FirebaseInit->makeResponce()
     */
    public function testMakeResponce()
    {
        $this->auth = new FirebaseAuth();

        $this->auth->setServertoken($this->token);
        $this->auth->setBaseURI($this->baseUri);
        // Auto-generated FirebaseInitTest::setUp()
        $this->firebaseInit = new Firebase($this->auth);

        $this->firebaseInit->get('users/');

        $this->assertNotEmpty($this->firebaseInit->getFirebaseData());

        return [
            'responce' => $this->firebaseInit->getFirebaseData(),
            'status' => $this->firebaseInit->getStatus(),
            'operation' => $this->firebaseInit->getOperation()
        ];
    }

    /**
     * Test FirebaseInit->getStatus()
     * @depends testMakeResponce
     *
     */
    public function testGetStatus()
    {
        $this->firebaseInit->get('users/');
        $this->assertNotNull($this->firebaseInit->getStatus());
        /* type int */
        $this->assertInternalType('int', $this->firebaseInit->getStatus());
    }

    /**
     * Test FirebaseInit->getOperation()
     * @depends testMakeResponce
     *
     */
    public function testGetOperation()
    {
        $this->firebaseInit->get('users/');
        $this->assertNotNull($this->firebaseInit->getOperation());

        /* type string */
        $this->assertInternalType('string', $this->firebaseInit->getOperation());
    }

    /**
     * Test FirebaseInit->getFirebaseData()
     * @depends testMakeResponce
     *
     */
    public function testGetFirebaseData()
    {
        $this->firebaseInit->get('users/');
        $this->assertNotNull($this->firebaseInit->getFirebaseData());

        /* type array */
        $this->assertInternalType('array', $this->firebaseInit->getFirebaseData());
    }

    /**
     * Test Firebase->getLastIdStored()
     *
     */
    public function testGetSetLastIdStored()
    {
        /* type string */
        $this->assertInternalType('string', $this->firebaseInit->getLastIdStored());
        /* assert empty string */
        $this->assertEquals('', $this->firebaseInit->getLastIdStored());

        $this->firebaseInit->setLastIdStored('id123abc');
        /* type string */
        $this->assertInternalType('string', $this->firebaseInit->getLastIdStored());
        /* assert empty string */
        $this->assertEquals('id123abc', $this->firebaseInit->getLastIdStored());
    }
}
