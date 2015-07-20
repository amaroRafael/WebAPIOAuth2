<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//$app->get('/', function() use ($app) {
//    return $app->welcome();
//});

$app->get('/', function() use ($app) {
    return view()->make('client');
});

$app->post('login', ['uses' => 'App\Http\Controllers\ProxyController@login']);//function() use($app) {
//    $credentials = request()->input('credentials');
//    return response()->make($credentials);
//    return $app->make('App\Http\OAuth\Proxy')->attemptLogin($credentials);
//});

$app->post('refresh-token', function() use($app) {
    return $app->make('App\Http\OAuth\Proxy')->attemptRefresh();
});

$app->post('oauth/access-token', function() use($app) {
    return response()->json($app->make('oauth2-server.authorizer')->issueAccessToken());
});

$app->group(['prefix' => 'api', 'middleware' => 'oauth'], function($app)
{
    $app->get('resource', function() {
        return response()->json([
            "id" => 1,
            "name" => "A resource"
        ]);
    });
});