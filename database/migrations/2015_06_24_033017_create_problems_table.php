<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('problems', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('title', 50);
            $table->string('author', 50);
            $table->string('institution', 60);
            $table->mediumText('description');
            $table->integer('numSolutions');
            $table->tinyInteger('limitTime');
            $table->double('limitMemory');
            $table->integer('numWarnings');
            $table->enum('state',['active','suspended','blocked','deleted']);
            $table->string('problemLink', 120);

            $table->integer('judgeList_id')->unsigned()->nullable();
            $table->foreign('judgeList_id')->references('id')->on('judges_lists');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('tag_id')->unsigned()->nullable();
            $table->foreign('tag_id')->references('id')->on('tags');




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
		Schema::drop('problems');
	}

}
