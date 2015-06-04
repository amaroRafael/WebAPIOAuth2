<?php namespace App\OAuth2Server\Middleware;

use Closure;
use App\OAuth2Server\Filters\OAuthFilter;

class OAuthMiddleware extends OAuthFilter {

    public function handle($request, Closure $next)
    {
        // Will throw exception on failure
        parent::filter();

        return $next($request);
    }
}