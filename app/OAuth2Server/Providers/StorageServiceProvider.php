<?php namespace App\OAuth2Server\Providers;
/**
 * Fluent Storage Service Provider for the OAuth 2.0 Server
 *
 */

use App\OAuth2Server\Storage\AccessTokenStorage;
use App\OAuth2Server\Storage\AuthCodeStorage;
use App\OAuth2Server\Storage\ClientStorage;
use App\OAuth2Server\Storage\RefreshTokenStorage;
use App\OAuth2Server\Storage\ScopeStorage;
use App\OAuth2Server\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;

class StorageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerStorageBindings();
        $this->registerInterfaceBindings();
    }

    /**
     * Bind the storage implementations to the IoC container
     * @return void
     */
    public function registerStorageBindings()
    {
        $provider = $this;

        $this->app->bindShared('App\OAuth2Server\Storage\AccessTokenStorage', function () use ($provider) {
            $storage = new AccessTokenStorage();
            return $storage;
        });

        $this->app->bindShared('App\OAuth2Server\Storage\AuthCodeStorage', function () use ($provider) {
            $storage = new AuthCodeStorage();
            return $storage;
        });

        $this->app->bindShared('App\OAuth2Server\Storage\ClientStorage', function ($app) use ($provider) {
            $limitClientsToGrants = $app['config']->get('oauth2.limit_clients_to_grants');
            $storage = new ClientStorage($limitClientsToGrants);
            return $storage;
        });

        $this->app->bindShared('App\OAuth2Server\Storage\RefreshTokenStorage', function () use ($provider) {
            $storage = new RefreshTokenStorage();
            return $storage;
        });

        $this->app->bindShared('App\OAuth2Server\Storage\ScopeStorage', function ($app) use ($provider) {
            $limitClientsToScopes = $app['config']->get('oauth2.limit_clients_to_scopes');
            $limitScopesToGrants = $app['config']->get('oauth2.limit_scopes_to_grants');
            $storage = new ScopeStorage($limitClientsToScopes, $limitScopesToGrants);
            return $storage;
        });

        $this->app->bindShared('App\OAuth2Server\Storage\SessionStorage', function () use ($provider) {
            $storage = new SessionStorage();
            return $storage;
        });
    }

    /**
     * Bind the interfaces to their implementations
     * @return void
     */
    public function registerInterfaceBindings()
    {
        $this->app->bind('League\OAuth2\Server\Storage\ClientInterface',       'App\OAuth2Server\Storage\ClientStorage');
        $this->app->bind('League\OAuth2\Server\Storage\ScopeInterface',        'App\OAuth2Server\Storage\ScopeStorage');
        $this->app->bind('League\OAuth2\Server\Storage\SessionInterface',      'App\OAuth2Server\Storage\SessionStorage');
        $this->app->bind('League\OAuth2\Server\Storage\AuthCodeInterface',     'App\OAuth2Server\Storage\AuthCodeStorage');
        $this->app->bind('League\OAuth2\Server\Storage\AccessTokenInterface',  'App\OAuth2Server\Storage\AccessTokenStorage');
        $this->app->bind('League\OAuth2\Server\Storage\RefreshTokenInterface', 'App\OAuth2Server\Storage\RefreshTokenStorage');
    }
}
 
