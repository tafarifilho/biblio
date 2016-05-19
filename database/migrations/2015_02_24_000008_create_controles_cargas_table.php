<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlesCargasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('controles_cargas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('cargas_id')->length(10)->unsigned();
			$table->foreign('cargas_id')->references('id')->on('cargas');
			$table->integer('funcionarios_id')->length(10)->unsigned();
			$table->foreign('funcionarios_id')->references('id')->on('users');
			$table->string('controle');
			$table->timestamps(); // Data
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
		Schema::drop('controles_cargas');
	}

}
