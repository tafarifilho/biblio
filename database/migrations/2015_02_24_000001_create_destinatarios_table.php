<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinatariosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('destinatarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('destinatario')->unique();
			//$table->string('predio')->nullable();
			//$table->string('endereco')->nullable();
			//$table->string('numero', 6)->nullable();
			//$table->string('complemento')->nullable();
			//$table->string('cidade')->nullable();
			//$table->string('estado')->nullable();
			//$table->string('cep')->nullable();
			//$table->string('telefone')->nullable();
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
		Schema::drop('destinatarios');
	}

}
