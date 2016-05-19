<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\AutoridadeTipo;

class AutoridadeTipoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$quantidadeLegada = DB::connection('legado')
												->table('tipo_auto')->count();

		$legadoAutoridadeTipo = DB::connection('legado')
														->table('tipo_auto')
														->orderBy('auto')
														->get();

		for ($i=0; $i < $quantidadeLegada; $i++)
		{

			// Criado o novo registro AutoridadeTipo
			$autoridadeTipo = new AutoridadeTipo;
			$autoridadeTipo->tipo        = mb_convert_encoding($legadoAutoridadeTipo[$i]->auto, 'Windows-1252', 'auto');
			$autoridadeTipo->prazo       = mb_convert_encoding($legadoAutoridadeTipo[$i]->prazo, 'Windows-1252', 'auto');
			$autoridadeTipo->save();

			// Atualizar Base Legada com Valores Temporários
			$atualizarLegadoAutoridadeTipo = DB::connection('legado')->table('autoridade')->where('id_tipo_auto', '=', $legadoAutoridadeTipo[$i]->id_tipo_auto)->update(array('id_tipo_auto' => $autoridadeTipo->id+10000));

			unset($autoridadeTipo);
			unset($atualizarLegadoAutoridadeTipo);
		}

		unset($quantidadeLegada);
		unset($legadoAutoridadeTipo);

		$this->command->info('AutoridadeTipoSeeder - Tabela de Tipo de Autoridades semeada!');
	}

}
