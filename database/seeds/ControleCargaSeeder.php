<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\ControleCarga;

class ControleCargaSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		/*
		**
		** Tempo de Execução - Início
		**
		*/
		$mtime = microtime(); 
		$mtime = explode(" ",$mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$starttime = $mtime; 


		/**
		*
		* Função para converter o timestamp para DateTime
		*
		*/
		function converteTimestamp($value)
		{
			// 10/17/2010 00:00:00 -> 1287273600
			// 02/20/2011 00:00:00 -> 1298160000
			// 10/16/2011 00:00:00 -> 1318723200
			// 02/26/2012 00:00:00 -> 1330214400
			// 10/21/2012 00:00:00 -> 1350777600
			// 02/17/2013 00:00:00 -> 1361059200
			// 10/20/2013 00:00:00 -> 1382227200
			// 02/16/2014 00:00:00 -> 1392508800
			// 10/19/2014 00:00:00 -> 1413676800
			// 02/22/2015 00:00:00 -> 1424563200

			if ( ($value >= 1287273600 && $value <= 1298160000) || ($value >= 1318723200 && $value <= 1330214400) || ($value >= 1350777600 && $value <= 1361059200) || ($value >= 1382227200 && $value <= 1392508800) || ($value >= 1413676800 && $value <= 1424563200) )
				return Carbon::createFromTimeStamp($value, 'America/Sao_Paulo')->addHour();
				//$value = strtotime('-2 hour', $value);
			else
				return Carbon::createFromTimeStamp($value, 'America/Sao_Paulo');
				//$value = strtotime('-3 hour', $value);

		}


		// Consulta todos os controles das cargas legadas
		$legadoControleCarga = DB::connection('legado')
														->table('cargactrl')
														->get();

		// Looping para resgatar todas os controles das cargas legadas
		for ($i=0; $i < count($legadoControleCarga); $i++)
		{
			// Criado o novo registro de Controle de Carga
			$controleCarga = new ControleCarga;

			$controleCarga->cargas_id       = mb_convert_encoding($legadoControleCarga[$i]->id_carga, 'Windows-1252', 'auto');
			$controleCarga->funcionarios_id = mb_convert_encoding($legadoControleCarga[$i]->funcctrl, 'Windows-1252', 'auto');
			$controleCarga->controle        = mb_convert_encoding($legadoControleCarga[$i]->controle, 'Windows-1252', 'auto');
			$controleCarga->created_at      = converteTimestamp(mb_convert_encoding($legadoControleCarga[$i]->stampctrl, 'Windows-1252', 'auto'));
			$controleCarga->updated_at      = date('Y-m-d H:i:s');

			// Salvando o novo Controle de Carga
			$controleCarga->save();

		} // FIM - Looping para resgatar todas os controles das cargas legadas

		/*
		**
		** Tempo de Execução - Final
		**
		*/
		$mtime = microtime(); 
		$mtime = explode(" ",$mtime); 
		$mtime = $mtime[1] + $mtime[0]; 
		$endtime = $mtime; 
		$totaltime = ($endtime - $starttime); 
		echo "\n ==> A tabela Controle de Carga foi semeada em ".$totaltime." segundos. \n";

		$this->command->info('ControleCargaSeeder - Tabela de Controle de Carga semeada!');
	}

}
