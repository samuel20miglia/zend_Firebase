<?php
declare(strict_types = 1);
namespace ZendFirebase\Config;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *         
 */
class AuthSetup
{

    /**
     * Base uri of firebase database
     *
     * @var string $_baseURI
     */
    private $_baseURI;

    /**
     * Token provide from Firebase
     *
     * @var string $_servertoken
     */
    private $_serverToken;

    public function __construct()
    {
        //
    }

    /**
     *
     * @return the $_baseURI
     */
    public function get_baseURI(): string
    {
        return $this->_baseURI;
    }

    /**
     *
     * @return the $_servertoken
     */
    public function get_servertoken(): string
    {
        return $this->_servertoken;
    }

    /**
     * Set String _baseURI
     *
     * @param string $_baseURI            
     */
    public function set_baseURI($_baseURI)
    {
        if (\strlen($_baseURI) == 0) {
            $str = 'You must provide a _baseURI variable.';
            trigger_error($str, E_USER_ERROR);
        }
        $_baseURI .= (substr($_baseURI, - 1) == '/' ? '' : '/');
        
        $this->_baseURI = \trim($_baseURI);
    }

    /**
     * Set string token
     *
     * @param string $_servertoken            
     */
    public function set_servertoken($_servertoken)
    {
        if ($_servertoken == '' or \strlen($_servertoken) == 0) {
            $str = 'You must provide a _baseURI variable.';
            trigger_error($str, E_USER_ERROR);
        }
        $this->_servertoken = \trim($_servertoken);
    }
}
