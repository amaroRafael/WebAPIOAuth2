<?php

use \App\Models\Oauth_client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class OAuthTableSeeder extends Seeder {

    public function run()
    {
        $config = app()->make('config');

        Oauth_client::query()->delete();

        Oauth_client::create([
            'id' => $config->get('secrets.client_id'),
            'secret' => $config->get('secrets.client_secret'),
            'name' => 'App'
        ]);   
    }

}

?>