<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSolutionUsersTable
 */
class CreateSolutionUserTable extends Migration {

	/**
	 * Run the migrations.
	 * @return void
	 */
	public function up()
	{
        /*Esta asi le dej para o perder eles la tabla de likes , por convencion de laravel se cambio el nombre para hacer el pivote */
		Schema::create('solution_user', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->integer('solution_id')->unsigned();
            $table->foreign('solution_id')->references('id')->on('solutions')->onDelete('cascade');





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
		Schema::drop('solution_user');
	}

}
