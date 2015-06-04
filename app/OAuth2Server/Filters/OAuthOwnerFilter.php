<?php namespace App\OAuth2Server\Filters;
/**
 * OAuth owner route filter
 *
 */

use League\OAuth2\Server\Exception\AccessDeniedException;
use App\OAuth2Server\Authorizer;

class OAuthOwnerFilter
{
    /**
     * The Authorizer instance
     * @var \LucaDegasperi\OAuth2Server\Authorizer
     */
    protected $authorizer;

    /**
     * @param Authorizer $authorizer
     */
    public function __construct(Authorizer $authorizer)
    {
        $this->authorizer = $authorizer;
    }

    /**
     * The main filter method
     * @internal param mixed $route, mixed $request, mixed $owners,...
     * @return null
     * @throws \League\OAuth2\Server\Exception\AccessDeniedException
     */
    public function filter()
    {
        if (func_num_args() > 2) {
            $ownerTypes = array_slice(func_get_args(), 2);
            if (!in_array($this->authorizer->getResourceOwnerType(), $ownerTypes)) {
                throw new AccessDeniedException();
            }
        }
        return null;
    }
}
