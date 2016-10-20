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
     *            $path
     * @param
     *            $data
     * @param
     *            $options
     * @return mixed
     */
    public function put($path, array $data, $options = array());

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
    public function post($path, array $data, $options = array());

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
    public function patch($path, array $data, $options = array());

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

