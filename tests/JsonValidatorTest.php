<?php
use ZendFirebase\Firebase\JsonValidator;

require_once 'src/JsonValidator.php';

/**
 * JsonValidator test case.
 */
class JsonValidatorTest extends PHPUnit_Framework_TestCase
{

    /**
     *
     * @var JsonValidator
     */
    private $jsonValidator;

    /**
     *
     * @var Json
     */
    protected $jsonData;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->jsonValidator = new JsonValidator();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->jsonValidator = null;
        
        parent::tearDown();
    }

    /**
     * Constructs the test case.
     */
    public function __construct()
    {
        /* set JsonData for test */
        $jsonData = [
            "test" => [
                "title" => "example",
                "another" => [
                    "title" => "S",
                    "list" => [
                        "ID" => 1,
                        "sort" => "asc",
                        "term" => "Standard"
                    ]
                ]
            ]
        ];
        
        $this->jsonData = json_encode($jsonData);
        
        /* assert Json */
        $this->assertJson($this->jsonData);
    }

    /**
     * Tests JsonValidator->__construct()
     */
    public function testConstruct()
    {
        $this->jsonValidator->__construct();
        
        /* assert not equals */
        $this->assertNotEquals(JsonValidator::class, $this->jsonValidator);
    }

    /**
     * Tests JsonValidator->getErrors()
     */
    public function testGetErrors()
    {
        /* call checkValidJson() for test getErrors() after called it */
        $this->jsonValidator->checkValidJson($this->jsonData);
        
        /* assert empty */
        $this->assertEmpty($this->jsonValidator->getErrors());
    }
}
