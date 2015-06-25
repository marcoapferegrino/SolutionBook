<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 45);
			$table->string('path', 120);
			$table->text('descripcion')->nullable();
            //$table->enum('type',['youtube','github','judge']);
			$table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade')->nullable();
			$table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade')->nullable();
			$table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade')->nullable();
			
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
		Schema::drop('files');
	}

}
