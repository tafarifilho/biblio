<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Predio;

class PredioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$quantidadeLegada = DB::connection('legado')
												->table('predio')
												->count();

		$legadoPredio = DB::connection('legado')
										->table('predio')
										->orderBy('predio')
										->get();

		for ($i=0; $i < $quantidadeLegada; $i++) {

			// Criado o novo registro Predio
			$predio = new Predio;
			$predio->predio       = mb_convert_encoding($legadoPredio[$i]->predio, 'Windows-1252', 'auto');
			$predio->endereco     = mb_convert_encoding($legadoPredio[$i]->endereco, 'Windows-1252', 'auto');
			$predio->numero       = mb_convert_encoding($legadoPredio[$i]->numero, 'Windows-1252', 'auto');
			$predio->complemento  = mb_convert_encoding($legadoPredio[$i]->complemento, 'Windows-1252', 'auto');
			$predio->cidade       = mb_convert_encoding($legadoPredio[$i]->cidade, 'Windows-1252', 'auto');
			$predio->estado       = mb_convert_encoding($legadoPredio[$i]->estado, 'Windows-1252', 'auto');
			$predio->cep          = mb_convert_encoding($legadoPredio[$i]->cep, 'Windows-1252', 'auto');
			$predio->tronco       = mb_convert_encoding($legadoPredio[$i]->tronco, 'Windows-1252', 'auto');
			$predio->save();

			// Atualizar a tabela Autoridade_Predio Legada com os novos IDs
			$atualizarLegadoAutoPredio = DB::connection('legado')->table('autopredio')->where('id_predio', '=', $legadoPredio[$i]->id_predio)->update(array('id_predio' => $predio->id+10000));

			unset($predio);
			unset($atualizarLegadoAutoPredio);
		}

		unset($quantidadeLegada);
		unset($legadoPredio);

		$this->command->info('PredioSeeder - Tabela de prédios semeada!');

	}

}
