<?php
namespace Interfaces;

/**
 * Interface FirebaseInterface
 *
 * @author Ventimiglia Samuel
 *         @sice 18/10/2016
 *        
 * @package Firebase
 */
interface FirebaseInterface
{

    /**
     *
     * @param
     *            $token
     * @return mixed
     */
    public function setToken($token);

    /**
     *
     * @param
     *            $baseURI
     * @return mixed
     */
    public function setBaseURI($baseURI);

    /**
     *
     * @param
     *            $path
     * @param
     *            $data
     * @param
     *            $options
     * @return mixed
     */
    public function put($path, $data, $options = array());

    /**
     *
     * @param
     *            $path
     * @param
     *            $data
     * @param
     *            $options
     * @return mixed
     */
    public function post($path, $data, $options = array());

    /**
     *
     * @param
     *            $path
     * @param
     *            $data
     * @param
     *            $options
     * @return mixed
     */
    public function patch($path, $data, $options = array());

    /**
     *
     * @param
     *            $path
     * @param
     *            $options
     * @return mixed
     */
    public function get($path, $options = array());

    /**
     *
     * @param
     *            $path
     * @param
     *            $options
     * @return mixed
     */
    public function delete($path, $options = array());
}

