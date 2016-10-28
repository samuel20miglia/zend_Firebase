<?php
namespace ZendFirebaseTest\Config;

use ZendFirebase\Config\FirebaseAuth;

require 'src/Config/FirebaseAuth.php';

/**
 * Test class for authentication object
 *
 * @author sviluppo
 *
 */
class AuthSetupTest extends \PHPUnit_Framework_TestCase
{

    protected $auth;
    // --- set up your own database here
    protected $baseUri = 'https://samplechat.firebaseio-demo.com/';

    protected $token = 'MqL0c8tKCtheLSYfrNINlnfn4t8jtgfgbfgjny';

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        // TODO Auto-generated AuthSetupTest::setUp()
        $this->auth = new FirebaseAuth();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        // TODO Auto-generated AuthSetupTest::tearDown()
        $this->auth = null;
        
        parent::tearDown();
    }

    public function testNoBaseURI()
    {
        $baseUri = '';
        $this->assertEquals('', $baseUri, 'You must provide a baseURI variable.');
    }

    /**
     * @depends testNoBaseURI
     */
    public function testNoServerToken()
    {
        $serverToken = '';
        $this->assertEquals('', $serverToken, 'You must provide serverToken.');
    }

    public function testSet()
    {
        $baseUri = \strlen($this->baseUri);
        $this->assertNotEquals(0, $baseUri);
    }
}
