<?php
namespace ZendFirebaseTest\Config;

use ZendFirebase\Config\AuthSetup;
require 'src/Config/AuthSetup.php';

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

    public function setUp()
    {
        $this->auth = new AuthSetup();
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
