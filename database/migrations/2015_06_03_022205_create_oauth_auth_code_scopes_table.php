<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthAuthCodeScopesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_auth_code_scopes', function(Blueprint $table)
		{
            $table->increments('id');
            $table->string('auth_code');
            $table->string('scope');
            $table->timestamps();

            $table->foreign('auth_code')->references('auth_code')->on('oauth_auth_codes')->onDelete('cascade');
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
		Schema::drop('oauth_auth_code_scopes');
	}

}
