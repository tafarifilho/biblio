<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargasTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('cargas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('autoridades_id')->length(10)->unsigned();
			$table->foreign('autoridades_id')->references('id')->on('autoridades');
			$table->string('carga', 60); // Str::random(60);
			$table->integer('mfn')->lenght(6)->unsigned()->nullable();
			$table->tinyInteger('cs', 0, 1)->nullable();
			$table->tinyInteger('estante', 0, 1)->nullable();
			$table->tinyInteger('prateleira', 0, 1)->nullable();
			$table->tinyInteger('numero', 0, 1)->nullable();
			$table->tinyInteger('digito', 0, 1)->nullable();
			$table->string('tombo')->nullable();
			$table->string('classificacao')->nullable();
			$table->string('notacao')->nullable();
			$table->string('volume')->nullable();
			$table->string('nome')->nullable();
			$table->string('titulo');
			$table->string('edicao')->nullable();
			$table->string('ano')->nullable();
			$table->timestamp('data_carga');
			$table->integer('funcionarios_carga_id')->length(10)->unsigned();
			$table->foreign('funcionarios_carga_id')->references('id')->on('users');
			$table->timestamp('data_baixa')->nullable();
			$table->integer('funcionarios_baixa_id')->length(10)->unsigned()->nullable();
			$table->foreign('funcionarios_baixa_id')->references('id')->on('users');
			$table->timestamp('data_cobranca');
			$table->integer('autoridades_predios_id')->length(10)->unsigned();
			$table->foreign('autoridades_predios_id')->references('id')->on('autoridades_predios');
			$table->integer('destinatarios_id')->length(10)->unsigned();
			$table->foreign('destinatarios_id')->references('id')->on('destinatarios');
			$table->string('solicitante');
			$table->string('email_solicitante');
			$table->integer('tipos_solicitacoes_id')->length(10)->unsigned();
			$table->foreign('tipos_solicitacoes_id')->references('id')->on('tipos_solicitacoes');
			$table->string('retirante')->nullable();
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
		Schema::drop('cargas');
	}

}
