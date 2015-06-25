<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolutionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('solutions', function(Blueprint $table)
		{
			$table->increments('id');
			$table->longText('explanation');
			$table->enum('state',['active','suspended','blocked','deleted']);
			$table->double('ranking');
			$table->string('solutionLink',45);
			$table->integer('numWarnings');
			$table->integer('numLikes');
			$table->integer('dislikes');

            $table->integer('problem_id')->unsigned();
			$table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('codeSolution_id')->unsigned();
			$table->foreign('codeSolution_id')->references('id')->on('code_solutions')->onDelete('cascade');
			
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
		Schema::drop('solutions');
	}

}
