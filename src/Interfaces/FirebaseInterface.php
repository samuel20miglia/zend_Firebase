<?php
namespace ZendFirebase\Interfaces;

/**
 * Interface FirebaseInterface
 *
 * @author Ventimiglia Samuel
 *         @sice 18/10/2016
 *
 * @package ZendFirebase
 */
interface FirebaseInterface
{

    /**
     *
     * @param unknown $path
     * @param array $data
     * @param array $options
     */
    public function put($path, array $data, $options = []);

    /**
     *
     * @param unknown $path
     * @param array $data
     * @param array $options
     */
    public function post($path, array $data, $options = []);

    /**
     *
     * @param unknown $path
     * @param array $data
     * @param array $options
     */
    public function patch($path, array $data, $options = []);

    /**
     *
     * @param unknown $path
     * @param array $options
     */
    public function get($path, $options = []);

    /**
     *
     * @param unknown $path
     * @param array $options
     */
    public function delete($path, $options = []);
}
