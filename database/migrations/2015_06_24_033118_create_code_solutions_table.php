<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCodeSolutionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('code_solutions', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('path',120);
            $table->enum('language',['c','c++','java','python']);
            $table->time('limitTime')->nullable();
            $table->double('limitMemory',20,15)->nullable();
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
		Schema::drop('code_solutions');
	}

}
