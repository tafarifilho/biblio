<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\TipoSolicitacao;

class TipoSolicitacaoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// A inserção será manual

		// Criado os novos registros de Tipo de Solicitacao

		// Legado
		$tipoSolicitacao = new TipoSolicitacao;
		$tipoSolicitacao->tipo = 'Legado';
		$tipoSolicitacao->save();

		// Solicitado por Email
		$tipoSolicitacao = new TipoSolicitacao;
		$tipoSolicitacao->tipo = 'Solicitado por Email';
		$tipoSolicitacao->save();

		// Solicitado por Telefone
		$tipoSolicitacao = new TipoSolicitacao;
		$tipoSolicitacao->tipo = 'Solicitado por Telefone';
		$tipoSolicitacao->save();

		// Solicitado pessoalmente
		$tipoSolicitacao = new TipoSolicitacao;
		$tipoSolicitacao->tipo = 'Solicitado Pessoalmente pela Autoridade';
		$tipoSolicitacao->save();

		$this->command->info('TipoSolicitacaoSeeder - Tabela de Tipos de Solicitacações semeada!');
	}

}
