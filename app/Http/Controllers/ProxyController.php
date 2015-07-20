<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxyController extends Controller
{
    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        return app()->make('App\Http\OAuth\Proxy')->attemptLogin($username, $password);
    }
}