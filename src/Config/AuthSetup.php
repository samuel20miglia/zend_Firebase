<?php
declare(strict_types = 1);
namespace ZendFirebase\Config;

/**
 *
 * @author sviluppo
 *        
 */
class AuthSetup
{

    /**
     *
     * @var string
     */
    private $baseUri;

    /**
     *
     * @var string
     */
    private $serverToken;

    public function __construct()
    {
        //
    }

    /**
     *
     * @return the $baseUri
     */
    public function getBaseUri(): string
    {
        return $this->baseUri;
    }

    /**
     *
     * @return the $serverToken
     */
    public function getServerToken(): string
    {
        return $this->serverToken;
    }

    /**
     *
     * @param string $baseUri            
     */
    public function setBaseUri($baseUri)
    {
        if (\strlen($baseUri) == 0) {
            trigger_error('You must provide a baseURI variable.', E_USER_ERROR);
        }
        $baseUri .= (substr($baseUri, - 1) == '/' ? '' : '/');
        
        $this->baseUri = \trim($baseUri);
    }

    /**
     *
     * @param string $serverToken            
     */
    public function setServerToken($serverToken)
    {
        if ($serverToken == '' or \strlen($serverToken) == 0) {
            trigger_error('You must provide a baseURI variable.', E_USER_ERROR);
        }
        $this->serverToken = \trim($serverToken);
    }
}

