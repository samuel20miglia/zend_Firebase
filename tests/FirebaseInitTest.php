<?php
namespace ZendFirebaseTest;

use ZendFirebase\FirebaseInit;
use ZendFirebase\Config\AuthSetup;
require_once 'src/FirebaseInit.php';
require_once 'src/Config/AuthSetup.php';

/**
 * FirebaseInit test case.
 */
class FirebaseInitTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var FirebaseInit
     */
    private $firebaseInit;
    
    // --- set up your own database here
    protected $baseUri = 'https://samplechat.firebaseio-demo.com/';

    protected $token = 'MqL0c8tKCtheLSYfrNINlnfn4t8jtgfgbfgjny';

    private $auth;

    private $path;

    private $options = [];

    private $operation;

    private $status;

    private $responce;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->auth = new AuthSetup();
        
        $this->auth->setServertoken($this->token);
        $this->auth->setBaseURI($this->baseUri);
        // TODO Auto-generated FirebaseInitTest::setUp()
        $this->firebaseInit = new FirebaseInit($this->auth);
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
     * Constructs the test case.
     */
    public function __construct()
    {
        //
    }

    /**
     * Tests FirebaseInit->__construct()
     */
    public function test__construct()
    {
        $this->firebaseInit->__construct($this->auth);
        
        $this->assertNotEquals(AuthSetup::class, $this->auth);
    }

    /**
     * Tests FirebaseInit->setTimeout()
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
     * Tests FirebaseInit->delete()
     */
    public function testDelete()
    {
        
        // TODO Auto-generated FirebaseInitTest->testGet()
        $this->markTestIncomplete("get test not implemented");
        $this->path = 'somePath';
        $this->options;
        $this->operation = 'DELETE';
        $this->status = 200;
        
        $this->firebaseInit->delete($this->path, $this->options);
        
        $this->assertEquals(200, $this->status, $this->firebaseInit);
    }

    /**
     * Tests FirebaseInit->get()
     */
    public function testGet()
    {
        // TODO Auto-generated FirebaseInitTest->testGet()
        $this->markTestIncomplete("get test not implemented");
        
        $this->firebaseInit->get(/* parameters */);
    }

    /**
     * Tests FirebaseInit->patch()
     */
    public function testPatch()
    {
        // TODO Auto-generated FirebaseInitTest->testPatch()
        $this->markTestIncomplete("patch test not implemented");
        
        $this->firebaseInit->patch(/* parameters */);
    }

    /**
     * Tests FirebaseInit->post()
     */
    public function testPost()
    {
        // TODO Auto-generated FirebaseInitTest->testPost()
        $this->markTestIncomplete("post test not implemented");
        
        $this->firebaseInit->post(/* parameters */);
    }

    /**
     * Tests FirebaseInit->put()
     */
    public function testPut()
    {
        // TODO Auto-generated FirebaseInitTest->testPut()
        $this->markTestIncomplete("put test not implemented");
        
        $this->firebaseInit->put(/* parameters */);
    }

    /**
     * Tests FirebaseInit->__destruct()
     */
    public function test__destruct()
    {
        $firebase = $this->firebaseInit->__destruct();
        
        $this->assertNull($firebase);
    }
}

