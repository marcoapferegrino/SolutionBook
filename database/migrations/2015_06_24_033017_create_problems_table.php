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
            $table->enum('state',['Active','Suspended','Blocked','Deleted']);
            $table->string('problemLink', 120);

            $table->integer('listJudge_id')->unsigned();
            $table->foreign('listJudge_id')->references('id')->on('judgesList')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('tag_id')->unsigned();
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');




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
