<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoridadesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('autoridades', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nome');
			$table->integer('autoridades_tipos_id')->length(10)->unsigned();
			$table->foreign('autoridades_tipos_id')->references('id')->on('autoridades_tipos');
			$table->string('genero')->nullable();
			$table->string('email')->nullable();
			$table->string('imagem')->nullable();
			$table->string('observacao')->nullable();
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
		Schema::drop('autoridades');
	}

}
