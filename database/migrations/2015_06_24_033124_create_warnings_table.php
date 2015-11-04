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
            $table->enum('reason',['copiedCode','notWorking','contentInapropiate','other']);
            $table->enum('state',['process','expired','forAdmin']);
            $table->integer('hoursToAttend');
            $table->integer('alerter_user')->unsigned();//user who makes warning

            $table->integer('solution_id')->unsigned()->nullable();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');

            $table->integer('user_id')->unsigned(); //owner of warning
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('problem_id')->unsigned()->nullable();
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

            $table->integer('link_id')->unsigned()->nullable();
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
