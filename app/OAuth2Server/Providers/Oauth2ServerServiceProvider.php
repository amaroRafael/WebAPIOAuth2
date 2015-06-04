<?php  namespace App\OAuth2Server\Providers;
/**
 * Created by PhpStorm.
 * User: ramaro
 * Date: 6/3/15
 * Time: 10:44 PM
 */

use App\OAuth2Server\Authorizer;
use App\OAuth2Server\Storage\AccessTokenStorage;
use App\OAuth2Server\Storage\AuthCodeStorage;
use App\OAuth2Server\Storage\ClientStorage;
use App\OAuth2Server\Storage\RefreshTokenStorage;
use App\OAuth2Server\Storage\ScopeStorage;
use App\OAuth2Server\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use League\OAuth2\Server\Grant\RefreshTokenGrant;
use League\OAuth2\Server\ResourceServer;

class Oauth2ServerServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     * @return void
     */
    public function register()
    {
        $this->registerConfiguration();
        $this->registerAuthorizer();
        $this->registerFilterBindings();
    }

    public function registerConfiguration() {
        $this->app->configure("oauth2");
    }

    /**
     * Register the Authorization server with the IoC container
     * @return void
     */
    public function registerAuthorizer()
    {

        $this->app->bindShared('oauth2-server.authorizer', function ($app) {

            $config = $app['config']->get('oauth2');

            // Authorization server
            $issuer = new AuthorizationServer();
            $issuer->setSessionStorage(new SessionStorage);
            $issuer->setAccessTokenStorage(new AccessTokenStorage);
            $issuer->setRefreshTokenStorage(new RefreshTokenStorage);
            $issuer->setClientStorage(new ClientStorage);
            $issuer->setScopeStorage(new ScopeStorage);
            $issuer->setAuthCodeStorage(new AuthCodeStorage);
            $issuer->requireScopeParam($config['scope_param']);
            $issuer->setDefaultScope($config['default_scope']);
            $issuer->requireStateParam($config['state_param']);
            $issuer->setScopeDelimiter($config['scope_delimiter']);
            $issuer->setAccessTokenTTL($config['access_token_ttl']);

            // add the supported grant types to the authorization server
            foreach ($config['grant_types'] as $grantIdentifier => $grantParams) {
                $grant = new $grantParams['class'];
                $grant->setAccessTokenTTL($grantParams['access_token_ttl']);

                if (array_key_exists('callback', $grantParams)) {
                    $grant->setVerifyCredentialsCallback($grantParams['callback']);
                }
                if (array_key_exists('auth_token_ttl', $grantParams)) {
                    $grant->setAuthTokenTTL($grantParams['auth_token_ttl']);
                }
                if (array_key_exists('refresh_token_ttl', $grantParams)) {
                    $grant->setRefreshTokenTTL($grantParams['refresh_token_ttl']);
                }
                $issuer->addGrantType($grant);
            }

            // Resource server
            $sessionStorage = new SessionStorage();
            $accessTokenStorage = new AccessTokenStorage();
            $clientStorage = new ClientStorage();
            $scopeStorage = new ScopeStorage();

            $checker = new ResourceServer(
                $sessionStorage,
                $accessTokenStorage,
                $clientStorage,
                $scopeStorage
            );

            $authorizer = new Authorizer($issuer, $checker);
            $authorizer->setRequest($app['request']);
            $authorizer->setTokenType($app->make($config['token_type']));

            $app->refresh('request', $authorizer, 'setRequest');

            return $authorizer;
        });

        $this->app->bind('App\OAuth2Server\Authorizer', function($app)
        {
            return $app['oauth2-server.authorizer'];
        });
    }

    /**
     * Register the Filters to the IoC container because some filters need additional parameters
     * @return void
     */
    public function registerFilterBindings()
    {
        $this->app->bindShared('App\OAuth2Server\Filters\CheckAuthCodeRequestFilter', function ($app) {
            return new CheckAuthCodeRequestFilter($app['oauth2-server.authorizer']);
        });

        $this->app->bindShared('App\OAuth2Server\Filters\OAuthFilter', function ($app) {
            $httpHeadersOnly = $app['config']->get('oauth2.http_headers_only');
            return new OAuthFilter($app['oauth2-server.authorizer'], $httpHeadersOnly);
        });

        $this->app->bindShared('App\OAuth2Server\Filters\OAuthOwnerFilter', function ($app) {
            return new OAuthOwnerFilter($app['oauth2-server.authorizer']);
        });
    }

    /**
     * Get the services provided by the provider.
     * @return string[]
     * @codeCoverageIgnore
     */
    public function provides()
    {
        return ['oauth2-server.authorizer'];
    }
}