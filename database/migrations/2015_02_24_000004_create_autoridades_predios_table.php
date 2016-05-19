<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoridadesPrediosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autoridades_predios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('autoridades_id')->length(10)->unsigned();
			$table->foreign('autoridades_id')->references('id')->on('autoridades');
			$table->integer('predios_id')->length(10)->unsigned();
			$table->foreign('predios_id')->references('id')->on('predios');
			$table->string('sala')->nullable();
			$table->string('complemento')->nullable();
			// $table->unique(array('autoridades_id', 'predios_id'));
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
		Schema::drop('autoridades_predios');
	}

}
