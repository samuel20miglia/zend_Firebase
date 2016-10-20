<?php
declare(strict_types = 1);
namespace ZendFirebase\Config;

/**
 * PHP7 FIREBASE LIBRARY (http://samuelventimiglia.it/)
 *
 *
 * @link https://github.com/Samuel18/zend_Firebase for the canonical source repository
 * @copyright Copyright (c) 2016-now Ventimiglia Samuel - Biasin Davide
 * @license BSD 3-Clause License
 *         
 *          Redistribution and use in source and binary forms, with or without
 *          modification, are permitted provided that the following conditions are met:
 *         
 *          Redistributions of source code must retain the above copyright notice, this
 *          list of conditions and the following disclaimer.
 *         
 *          Redistributions in binary form must reproduce the above copyright notice,
 *          this list of conditions and the following disclaimer in the documentation
 *          and/or other materials provided with the distribution.
 *         
 *          Neither the name of the copyright holder nor the names of its
 *          contributors may be used to endorse or promote products derived from
 *          this software without specific prior written permission.
 *         
 *          THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 *          AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 *          IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 *          DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE
 *          FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL
 *          DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 *          SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 *          CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY,
 *          OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 *          OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *         
 *         
 *          THIS CLASS IF FOR CREATE AUTHENTICATION
 *          PLEASE SET URL OF DATABASE AND TOKEN
 */
class AuthSetup
{

    /**
     * Base uri of firebase database
     *
     * @var string $baseUri
     */
    private $baseUri;

    /**
     * Token provide from Firebase
     *
     * @var string $serverToken
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
     * Set String baseuri
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
     * Set string token
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

