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

<<<<<<< HEAD
            $table->string('description');
=======
     $table->string('description');
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178
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

<<<<<<< HEAD
            $table->timestamps();
=======
			$table->timestamps();
>>>>>>> 86fba373a95e3e2c0b7d62449c7c986059013178
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
