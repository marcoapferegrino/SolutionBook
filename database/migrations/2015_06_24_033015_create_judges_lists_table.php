<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgesListsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('judges_lists', function(Blueprint $table)
		{
			$table->increments('id');


            $table->string('name',45);
            $table->string('addressWeb',30);
//            $table->string('contact',45);
            $table->string('facebook');
            $table->string('twitter');
            $table->string('image');

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
		Schema::drop('judges_lists');
	}

}
