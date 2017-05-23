<?php
namespace Zend\Firebase\Interfaces;

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
    public function put(string $path, array $data, array $options = []);

    /**
     *
     * @param unknown $path
     * @param array $data
     * @param array $options
     */
    public function post(string $path, array $data, array $options = []);

    /**
     *
     * @param unknown $path
     * @param array $data
     * @param array $options
     */
    public function patch(string $path, array $data, array $options = []);

    /**
     *
     * @param unknown $path
     * @param array $options
     */
    public function get(string $path, array $options = []);

    /**
     *
     * @param unknown $path
     * @param array $options
     */
    public function delete(string $path, array $options = []);
}
