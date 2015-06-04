<?php namespace App\OAuth2Server\Filters;
/**
 * OAuth parameters check route middleware
 *
 */

use App\OAuth2Server\Authorizer;

class CheckAuthCodeRequestFilter
{
    /**
     * The authorizer instance
     */
    protected $authorizer;

    /**
     * @param Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    public function filter()
    {
        $this->authorizer->checkAuthCodeRequest();
    }
}
