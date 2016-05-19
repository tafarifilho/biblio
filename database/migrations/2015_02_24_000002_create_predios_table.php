<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrediosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('predios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('predio')->unique();
			$table->string('endereco');
			$table->string('numero', 6);
			$table->string('complemento');
			$table->string('cidade');
			$table->string('estado', 2);
			$table->string('cep', 9);
			$table->string('tronco');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('predios');
	}

}
