<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthAuthCodesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_auth_codes', function(Blueprint $table)
		{
            $table->string('auth_code')->primary();
            $table->integer('session_id')->unsigned();
            $table->integer('expire_time');
            $table->string('client_redirect_uri');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_auth_codes');
	}

}
