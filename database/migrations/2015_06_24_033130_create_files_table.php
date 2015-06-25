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
			$table->text('description')->nullable();
            $table->enum('type',['imagenEjemplo','imagenApoyo','notaVoz','fileinput','fileOutput']);


            $table->integer('solution_id')->unsigned()->nullable();
			$table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');

            $table->integer('problem_id')->unsigned()->nullable();
			$table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

            $table->integer('notification_id')->unsigned()->nullable();
			$table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
			
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
