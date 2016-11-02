<?php
use ZendFirebase\Stream\StreamEvent;

require_once 'src/Stream/StreamEvent.php';

/**
 * StreamEvent test case.
 *
 * @author Davide Biasin
 */
class StreamEventTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var StreamEvent
     */
    private $streamEvent;

    /**
     *
     * @var StreamEventWithData
     */
    private $streamEventWithData;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();

        /* Create instance of StreamEvent without passing the data to the construct */
        $this->streamEvent = new StreamEvent();

        /* Create instance of StreamEvent with passing the data to the construct */
        $this->streamEventWithData = new StreamEvent('data', 'operation');
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        /* reset streamEvent istance */
        $this->streamEvent = null;
        /* reset streamEvent istance */
        $this->streamEventWithData = null;

        parent::tearDown();
    }

    /**
     * Tests StreamEvent->__construct()
     */
    public function test__construct()
    {
        /* Equals default value */
        $this->assertEquals(null,$this->streamEvent->getData() );
        $this->assertEquals('message',$this->streamEvent->getEventType());

        /* Equals value passed */
        $this->assertEquals('data',$this->streamEventWithData->getData());
        $this->assertEquals('operation',$this->streamEventWithData->getEventType() );
    }

    /**
     * Tests StreamEvent->getData()
     */
    public function testGetData()
    {
        /* Empty, default value */
        $this->assertEmpty(null,$this->streamEvent->getData());

        /* Not empty, passed value from construct */
        $this->assertNotEmpty($this->streamEventWithData->getData());

        /* type string */
        $this->assertInternalType('string', $this->streamEventWithData->getData());
    }

    /**
     * Tests StreamEvent->getEventType()
     */
    public function testGetEventType()
    {
        /* Not empty */
        $this->assertNotEmpty($this->streamEvent->getEventType());

        /* type string */
        $this->assertInternalType('string', $this->streamEventWithData->getEventType());
    }

    /**
     * Tests StreamEvent::parse()
     */
    public function testParse()
    {
        $event = StreamEvent::parse("event: testEvent\ndata: testData");

        /* Equal than event parameter passed */
        $this->assertEquals(null,$event->getEventType() );
        /* Equal than data parameter passed */
        $this->assertEquals(null,$event->getData());

        /* type string */
        $this->assertInternalType('string', $event->getEventType());
        /* type string */
        $this->assertInternalType('string', $event->getData());
    }

    /**
     * Tests StreamEvent::parse()
     */
    public function testParseEmpty()
    {
        $event = StreamEvent::parse('data');

        /* empty string */
        $this->assertEquals('', $event->getData());
        /* default string 'message' */
        $this->assertEquals('message', $event->getEventType());
    }
}
