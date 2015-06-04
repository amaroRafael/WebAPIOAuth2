<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOauthSessionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_sessions', function(Blueprint $table)
		{
            $table->increments('id')->unsigned();
            $table->string('owner_type');
            $table->string('owner_id');
            $table->string('client_id');
            $table->string('client_redirect_uri')->nullable();
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('oauth_clients')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_sessions');
	}

}
