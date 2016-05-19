<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\AutoridadeTelefone;

class AutoridadeTelefoneSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$quantidadeLegada = DB::connection('legado')
													->table('autotel')->count();

		$legadoAutoridadeTelefone = DB::connection('legado')
																->table('autotel')
																->get();

		for ($i=0; $i < $quantidadeLegada; $i++)
		{

			// Criado o novo registro Autoridade Telefone
			$autoridadeTelefone = new AutoridadeTelefone;
			$autoridadeTelefone->autoridades_id  = mb_convert_encoding($legadoAutoridadeTelefone[$i]->id_auto, 'Windows-1252', 'auto');
			$autoridadeTelefone->telefone        = mb_convert_encoding($legadoAutoridadeTelefone[$i]->telefone, 'Windows-1252', 'auto');
			$autoridadeTelefone->save();

			// Atualizar Base Legada com Valores Temporários
			// Sem alterações na base legada

			unset($autoridadeTelefone);
		}

		unset($quantidadeLegada);
		unset($legadoAutoridadeTelefone);

		$this->command->info('AutoridadeTelefoneSeeder - Tabela de Telefone da Autoridades semeada!');
	}

}
