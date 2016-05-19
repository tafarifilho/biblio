<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoridadesTelefonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autoridades_telefones', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('autoridades_id')->length(10)->unsigned();
			$table->foreign('autoridades_id')->references('id')->on('autoridades');
			$table->string('telefone');
			$table->string('tipo_telefone');
			$table->unique(array('autoridades_id', 'telefone'));
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
		Schema::drop('autoridades_telefones');
	}

}
