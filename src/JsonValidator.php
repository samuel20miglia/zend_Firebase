<?php
declare(strict_types = 1);
namespace ZendFirebase\Firebase;

/**
 *
 * @author Ventimiglia Samuel - Biasin Davide
 *        
 */
class JsonValidator
{

    /**
     *
     * @var string
     */
    protected $errors;

    /**
     */
    public function __construct()
    {}

    /**
     */
    public function __destruct()
    {}

    /**
     *
     * @return the $errors
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     *
     * @param string $errors            
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     *
     * @author Davdie Biasin
     *        
     * @tutorial Method to check validity of json passed
     *          
     * @param
     *            string
     * @return boolean
     */
    public function checkValidJson($json)
    {
        try {
            json_decode($json);
            
            if (json_last_error() === JSON_ERROR_NONE) {
                // Correct Json
                return true;
            } else {
                switch (json_last_error()) {
                    case JSON_ERROR_DEPTH:
                        self::setErrors(' - Maximum stack depth exceeded');
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        self::setErrors(' - Underflow or the modes mismatch');
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        self::setErrors(' - Unexpected control character found');
                        break;
                    case JSON_ERROR_SYNTAX:
                        self::setErrors(' - Syntax error, malformed JSON');
                        break;
                    case JSON_ERROR_UTF8:
                        self::setErrors(' - Malformed UTF-8 characters, possibly incorrectly encoded');
                        break;
                    default:
                        self::setErrors(' - Unknown error');
                        break;
                }
                return false;
            }
        } catch (\RuntimeException $e) {
            $this->setErrors($e->getMessage());
        }
    }
}
