<?php
use ZendFirebase\Stream\StreamClient;

require_once 'src/Stream/StreamClient.php';

/**
 * StreamClient test case.
 *
 * @author Davide Biasin
 */
class StreamClientTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var StreamClient
     */
    private $streamClient;

    /**
     * Url
     *
     * @var string
     */
    private $url = 'https://zendfirebase.firebaseio.com/';
    
    /**
     * Password
     *
     * @var string
     */
    private $auth = 'users.json?auth=YdLUSTlxVOAEEuLAMpB49lAm98AMMCMMWm6y82r4';
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        
        /* New instance of StreamClient */
        $this->streamClient = new StreamClient($this->url, 0,$this->auth);
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        /* Reset stremClient instance */
        $this->streamClient = null;

        parent::tearDown();
    }

    /**
     * Tests StreamClient->__construct()
     *
     * @expectedException InvalidArgumentException
     */
    public function test__construct()
    {
        $this->streamClient->__construct('', 0,'');
    }

    /**
     * Tests StreamClient->getLastMessageId()
     *
     * @expectedException TypeError
     */
    public function testGetLastMessageId()
    {
        /* empty */
        $this->assertEmpty($this->streamClient->getLastMessageId());
    }

    /**
     * Tests StreamClient->setLastMessageId()
     */
    public function testSetLastMessageId()
    {
        $this->streamClient->setLastMessageId('test last message');

        /* not empty */
        $this->assertNotEmpty($this->streamClient->getLastMessageId());
        /* type string */
        $this->assertInternalType('string', $this->streamClient->getLastMessageId());
        /* equals than 'test last message' */
        $this->assertEquals($this->streamClient->getLastMessageId(), 'test last message');
        /* not equals than '' */
        $this->assertNotEquals($this->streamClient->getLastMessageId(), '');
    }

    /**
     * Tests StreamClient->getEvents()
     */
    public function testGetEvents()
    {
        $event = $this->streamClient->getEvents();

        /* not equals than '' */
        $this->assertNotEquals(null, $event);
    }
}
