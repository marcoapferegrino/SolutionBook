<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('email')->unique();
			$table->string('password', 60);
            $table->enum('rol',['problem','solver','super']);
            $table->integer('ranking');
            $table->string('avatar')->nullable();//path de la foto de perfil
            $table->enum('state',['active','inactive','suspended','blocked']);
            $table->integer('numWarnings');
            $table->string('institution',50)->nullable();//escuela a la que pertenece


			$table->integer('userProblem_id')->unsigned()->nullable();
			$table->foreign('userProblem_id')->references('id')->on('users');

			$table->rememberToken();
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
		Schema::drop('users');
	}

}
