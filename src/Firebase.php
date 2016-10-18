<?php
use Interfaces\FirebaseInterface, \Config\AuthSetup as Auth, \Config\Operations as Operations;

/**
 *
 * @author Ventimiglia Samuel
 *        
 */
class Firebase implements FirebaseInterface
{

    /**
     *
     * @var integer
     */
    private $_timeout = 30;

    /**
     */
    public function __construct()
    {}

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::delete()
     */
    public function delete($path, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::get()
     */
    public function get($path, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::patch()
     */
    public function patch($path, $data, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::post()
     */
    public function post($path, $data, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::put()
     */
    public function put($path, $data, $options = array())
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::setBaseURI()
     */
    public function setBaseURI($baseURI)
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::setTimeOut()
     */
    public function setTimeOut($seconds)
    {
        // TODO Auto-generated method stub
    }

    /**
     *
     * {@inheritdoc}
     *
     * @see \Interfaces\FirebaseInterface::setToken()
     */
    public function setToken($token)
    {
        // TODO Auto-generated method stub
    }

    /**
     */
    public function __destruct()
    {
        
        // TODO - Insert your code here
    }
}

