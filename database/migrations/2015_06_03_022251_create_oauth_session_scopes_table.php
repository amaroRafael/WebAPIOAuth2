<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthSessionScopesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_session_scopes', function(Blueprint $table)
		{
            $table->increments('id')->unsigned();
            $table->integer('session_id')->unsigned();
            $table->string('scope');
            $table->timestamps();

            $table->foreign('session_id')->references('id')->on('oauth_sessions')->onDelete('cascade');
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
		Schema::drop('oauth_session_scopes');
	}

}
