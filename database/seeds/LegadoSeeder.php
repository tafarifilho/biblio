<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Carga;

class LegadoSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		$cargas = Carga::all();

		for ($i=1; $i <= count($cargas); $i++)
		{ 
			$carga = Carga::find($i);
			if ($carga->destinatarios_id == 3) 
			{
				$carga->destinatarios_id       = 10004;
				$carga->autoridades_predios_id = 710;
				$carga->save();
			}
			elseif ($carga->destinatarios_id == 4)
			{
				$carga->destinatarios_id       = 10004;
				$carga->autoridades_predios_id = 709;
				$carga->save();
			}
			elseif ($carga->destinatarios_id == 7)
			{
				$carga->destinatarios_id       = 10004;
				$carga->autoridades_predios_id = 669;
				$carga->save();
			}
			elseif ($carga->destinatarios_id == 8)
			{
				$carga->destinatarios_id       = 10004;
				$carga->autoridades_predios_id = 518;
				$carga->save();
			}
			elseif ($carga->destinatarios_id == '0')
			{
				$carga->destinatarios_id       = 10000;
				$carga->save();
			}

		}

		DB::update('UPDATE autoridades set autoridades_tipos_id = autoridades_tipos_id - 10000');
		DB::update('UPDATE autoridades_predios set autoridades_id = autoridades_id - 10000');
		DB::update('UPDATE autoridades_predios set predios_id = predios_id - 10000');
		DB::update('UPDATE autoridades_telefones set autoridades_id = autoridades_id - 10000');
		DB::update('UPDATE cargas set destinatarios_id = destinatarios_id - 10000');
		DB::update('UPDATE cargas set autoridades_id = autoridades_id - 10000');
		DB::update('UPDATE controles_cargas set cargas_id = cargas_id - 10000');

		$this->command->info('LegadoSeeder - Tabelas com chaves reduzidas!');
	}

}
