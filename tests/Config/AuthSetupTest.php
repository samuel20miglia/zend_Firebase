<?php
namespace ZendFirebaseTest\Firebase\Config;

use ZendFirebase\Config\AuthSetup;
require_once __DIR__ . "/../src/Config/AuthSetup.php";

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

    const DEFAULT_URI_ERROR = 'You must provide a baseURI variable.';

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
