<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Autoridade;

class AutoridadeSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$quantidadeLegada = DB::connection('legado')
												->table('autoridade')->count();

		$legadoAutoridade = DB::connection('legado')
														->table('autoridade')
														->get();

		for ($i=0; $i < $quantidadeLegada; $i++)
		{

			// Criado o novo registro Autoridade
			$autoridade = new Autoridade;
			$autoridade->nome                  = mb_convert_encoding($legadoAutoridade[$i]->nome, 'Windows-1252', 'auto');
			$autoridade->autoridades_tipos_id  = mb_convert_encoding($legadoAutoridade[$i]->id_tipo_auto, 'Windows-1252', 'auto');

			if ( ($legadoAutoridade[$i]->email !== 'NULL' ) && ($legadoAutoridade[$i]->email !== '@biblioteca.br' ) )
				$autoridade->email             = mb_convert_encoding($legadoAutoridade[$i]->email, 'Windows-1252', 'auto');
			//$autoridade->observacao            = mb_convert_encoding($legadoAutoridade[$i]->observacao, 'Windows-1252', 'auto');

			$autoridade->save();

			// Atualizar Base Legada com Valores Temporários
			$atualizarLegadoAutoPredio = DB::connection('legado')->table('autopredio')->where('id_auto', '=', $legadoAutoridade[$i]->id_auto)->update(array('id_auto' => $autoridade->id+10000));
			$atualizarLegadoAutoTel = DB::connection('legado')->table('autotel')->where('id_auto', '=', $legadoAutoridade[$i]->id_auto)->update(array('id_auto' => $autoridade->id+10000));
			$atualizarLegadoCarga = DB::connection('legado')->table('carga')->where('id_auto', '=', $legadoAutoridade[$i]->id_auto)->update(array('id_auto' => $autoridade->id+10000));

			unset($autoridade);
			unset($atualizarLegadoAutoPredio);
			unset($atualizarLegadoAutoTel);
			unset($atualizarLegadoCarga);
		}

		unset($quantidadeLegada);
		unset($legadoAutoridade);

		$this->command->info('AutoridadeSeeder - Tabela de Tipo de Autoridades semeada!');
	}

}
