<?php
namespace ZendFirebase\Config;

/**
 *
 * Available type of operations
 *
 * @author Ventimiglia Samuel
 * @package Firebase
 *         
 */
class Operations
{

    const GET = 'GET';

    const PUT = 'PUT';

    const POST = 'POST';

    const PATCH = 'PATCH';

    const DELETE = 'DELETE';

    /**
     * Return all constant of class
     */
    public static function getConstants()
    {
        $oClass = new \ReflectionClass(__CLASS__);
        return $oClass->getConstants();
    }
}
