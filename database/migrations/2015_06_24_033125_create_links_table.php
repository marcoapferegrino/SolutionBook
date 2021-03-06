<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLinksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('links', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('link');
            $table->enum('type',['YouTube','Repositorio','Facebook','Twitter','JuezOnline','Amonestación','Referencia','Web']);

            $table->integer('solution_id')->unsigned()->nullable();
			$table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');

            $table->integer('problem_id')->unsigned()->nullable();
            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');

			$table->integer('warning_id')->unsigned()->nullable();
			$table->foreign('warning_id')->references('id')->on('warnings')->onDelete('cascade');

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
		Schema::drop('links');
	}

}
