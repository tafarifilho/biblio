<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\AutoridadePredio;

class AutoridadePredioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$quantidadeLegada = DB::connection('legado')
												->table('autopredio')->count();

		$legadoAutoridadePredio = DB::connection('legado')
														->table('autopredio')
														->get();

		for ($i=0; $i < $quantidadeLegada; $i++)
		{

			// Criado o novo registro Autoridade Predio
			$autoridadePredio = new AutoridadePredio;
			$autoridadePredio->autoridades_id  = mb_convert_encoding($legadoAutoridadePredio[$i]->id_auto, 'Windows-1252', 'auto');
			$autoridadePredio->predios_id      = mb_convert_encoding($legadoAutoridadePredio[$i]->id_predio, 'Windows-1252', 'auto');

			if ($legadoAutoridadePredio[$i]->gabinete !== 'NULL')
				$autoridadePredio->sala        = mb_convert_encoding($legadoAutoridadePredio[$i]->gabinete, 'Windows-1252', 'auto');
			//$autoridadePredio->complemento   = mb_convert_encoding($legadoAutoridadePredio[$i]->, 'Windows-1252', 'auto');

			$autoridadePredio->save();

			// Atualizar Base de Cargas com o Novo ID
			// Ocorre em virtude de IDs inexistentes em virtude de exclusão
			$atualizarLegadoAutoPredio = DB::connection('legado')->table('carga')->where('id_autopredio', '=', $legadoAutoridadePredio[$i]->id_autopredio)->update(array('id_autopredio' => $autoridadePredio->id));

			unset($autoridadePredio);
			unset($atualizarLegadoAutoPredio);
		}

		unset($quantidadeLegada);
		unset($legadoAutoridadePredio);

		$this->command->info('AutoridadePredioSeeder - Tabela de Prédios da Autoridades semeada!');
	}

}
