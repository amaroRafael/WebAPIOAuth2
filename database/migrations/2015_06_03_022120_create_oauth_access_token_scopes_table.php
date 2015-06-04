<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthAccessTokenScopesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_access_token_scopes', function(Blueprint $table)
		{
            $table->increments('id')->unsigned();
            $table->string('access_token');
            $table->string('scope');
            $table->timestamps();

            $table->foreign('access_token')->references('access_token')->on('oauth_access_tokens')->onDelete('cascade');
            $table->foreign('scope')->references('id')->on('oauth_scopes')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_access_token_scopes');
	}

}
