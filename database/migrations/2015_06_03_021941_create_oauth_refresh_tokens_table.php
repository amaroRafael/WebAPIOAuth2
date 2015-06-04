<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthRefreshTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_refresh_tokens', function(Blueprint $table)
		{
            $table->string('refresh_token')->primary();
            $table->integer('expire_time');
            $table->string('access_token');
            $table->timestamps();

            $table->foreign('access_token')->references('access_token')->on('oauth_access_tokens')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_refresh_tokens');
	}

}
