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
class FirebaseAuthSetup
{

    /**
     * Base uri of firebase database
     *
     * @var string $baseURI
     */
    private $baseURI;

    /**
     * Token provide from Firebase
     *
     * @var string $servertoken
     */
    private $serverToken;

    public function __construct()
    {
        //
    }

    /**
     *
     * @return the $baseURI
     */
    public function getBaseURI(): string
    {
        return $this->baseURI;
    }

    /**
     *
     * @return the $servertoken
     */
    public function getServertoken(): string
    {
        return $this->serverToken;
    }

    /**
     * Set String baseURI
     *
     * @param string $baseURI
     */
    public function setBaseURI($baseURI)
    {
        if (\strlen($baseURI) == 0) {
            $str = 'You must provide a baseURI variable.';
            trigger_error($str, E_USER_ERROR);
        }
        $baseURI .= (substr($baseURI, - 1) == '/' ? '' : '/');
        
        $this->baseURI = \trim($baseURI);
    }

    /**
     * Set string token
     *
     * @param string $servertoken
     */
    public function setServertoken($servertoken)
    {
        if ($servertoken == '' || \strlen($servertoken) == 0) {
            $str = 'You must provide serverToken.';
            trigger_error($str, E_USER_ERROR);
        }
        $this->serverToken = \trim($servertoken);
    }
}
