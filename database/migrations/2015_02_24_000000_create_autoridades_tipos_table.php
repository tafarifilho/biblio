<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoridadesTiposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autoridades_tipos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('tipo')->unique();
			$table->string('tratamento')->nullable();
			$table->string('abreviado')->nullable();
			$table->smallInteger('prazo')->unsigned();
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
		Schema::drop('autoridades_tipos');
	}

}
