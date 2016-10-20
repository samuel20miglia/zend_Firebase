<?php
namespace ZendFirebaseTest\Firebase\Config;

use ZendFirebase\Config\AuthSetup;

/**
 *
 * @author sviluppo
 *        
 */
class AuthSetupTest extends \PHPUnit_Framework_TestCase
{

    protected $auth;
    // --- set up your own database here
    const DEFAULT_URL = 'https://';

    const DEFAULT_TOKEN = 'MqL0c8tKCtheLSYcygYNtGhU8Z2hULOFs9OKPdEp';

    public function setUp()
    {
        $this->auth = new AuthSetup();
    }

    public function testNoBaseURI()
    {
        $errorMessage = null;
        try {} catch (\Exception $e) {
            $errorMessage = $e->getMessage();
        }
        
        $this->assertEquals(self::DEFAULT_URI_ERROR, $errorMessage);
    }
}
