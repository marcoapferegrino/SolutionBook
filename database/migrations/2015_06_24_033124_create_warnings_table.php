<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarningsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('warnings', function(Blueprint $table)
		{
			$table->increments('id');

     $table->string('description');
            $table->enum('reason',['copiedCode','notWorking','contentInapropiate']);
            $table->enum('state',['process','expired']);
            $table->integer('hoursToAttend');

            $table->integer('solution_id')->unsigned();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('problems_id')->unsigned();
            $table->foreign('problems_id')->references('id')->on('problems')->onDelete('cascade');

            $table->integer('link_id')->unsigned();
            $table->foreign('link_id')->references('id')->on('links')->onDelete('cascade');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('warnings');
	}

}
