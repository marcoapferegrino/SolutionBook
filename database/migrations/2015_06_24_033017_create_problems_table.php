o<?php

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
            $table->string('institution', 60)->nullable();
            $table->mediumText('description');
            $table->integer('numSolutions');
            $table->time('limitTime')->default(0);
            $table->double('limitMemory')->default(0);//kb
            $table->integer('numWarnings')->default(0);
            $table->enum('state',['active','suspended','blocked','deleted'])->default('active');
            $table->enum('share',['yes','no'])->default('no');
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
