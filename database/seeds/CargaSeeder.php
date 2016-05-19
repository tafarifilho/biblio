<?php
ini_set('memory_limit', '512M');

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Carga;

class CargaSeeder extends Seeder {

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
		* Função para converter o tombo legado para um tombo possível de pesquisa na base DOB
		*
		*/
		function converteTombo($value)
		{
			$novo_tombo = "";
			// Retirar todas as letras do tombo
			$sem_letras = preg_replace("/[ˆa-zA-Z]/i", "", $value);
			// Retirar todos os números e outros caracteres do tombo
			$so_texto = preg_replace("/[ˆ0-9.-]/i", "", $value);
			// Explodir o número com base no digito
			$separado_pelo_digito = explode("-", $sem_letras);
			// Remove o ponto da centenas, se existir
			$so_numero = preg_replace("/[.]/i", "", $separado_pelo_digito[0]);
			// Inserir zero a esquerda
			if(strlen($so_numero) <= 5)
				$so_numero = str_pad($so_numero, 5, "0", STR_PAD_LEFT);
			// Inserir o ponto na centena
			$so_numero = substr($so_numero, 0, -3) . '.' . substr($so_numero, -3);
			// Definir a base do novo tombo
			$novo_tombo = $so_numero;
			// Se exitir digito, inseri-lo
			if(count($separado_pelo_digito) != 1)
				$novo_tombo = $novo_tombo . '-' . $separado_pelo_digito[1];
			if(!empty($so_texto))
				$novo_tombo = $novo_tombo . $so_texto;
			return $novo_tombo;
		}

		/**
		*
		* Função para converter o timestamp para DateTime
		*
		*/
		function converteTimestamp($value)
		{
			// Hoários de Verão
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
			else
				return Carbon::createFromTimeStamp($value, 'America/Sao_Paulo');
		}


		// Consulta todos as cargas legadas
		$legadoCarga = DB::connection('legado')
														->table('carga')
														->get();

		// Definir e zerar as variáveis de contagem
		$achadosTombo = 0;
		$nao_achadosTombo = 0;
		$achadosLocalizacao = 0;
		$nao_achadosLocalizacao = 0;

		// Looping para resgatar todas as cargas legadas
		for ($i=0; $i < count($legadoCarga); $i++)
		{

			// Criado o novo registro de Carga
			$carga = new Carga;
			$carga->autoridades_id          = mb_convert_encoding($legadoCarga[$i]->id_auto, 'Windows-1252', 'auto');
			$carga->carga                   = mb_convert_encoding($legadoCarga[$i]->carga, 'Windows-1252', 'auto');

			// Procurando padrões para inserir corretamente
			$tombo_legado                   = mb_convert_encoding($legadoCarga[$i]->tombo, 'Windows-1252', 'auto');

			// Se o Tombo for um valor existe, procurar campos na DOB.
			if (!empty($tombo_legado) && $tombo_legado !== 'NULL' && $tombo_legado !== 'ST' && $tombo_legado !== 'S/T')
			{
				$tombo = converteTombo($tombo_legado);

				$dob = DB::connection('mongodb')
							->collection('dob')
							->where('v10._', 'like', "%$tombo%")
							->orWhere('v12._', 'like', "%$tombo%")
							->where(function($query)
							{
								$query->where('v8._', '=', 'Livro')
											->orWhere('v8._', '=', 'Livro ')
											->orWhere('v8._', '=', 'livro')
											->orWhere('v8._', '=', 'Tese')
											->orWhere('v8._', '=', 'Folheto')
											->orWhere('v8._', '=', 'Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - obra rara')
											->orWhere('v8._', '=', ' Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - Obra Rara');
							})->get();

				// Foi encontrada 1 correspondência do tombo na DOB
				if (count($dob) === 1)
				{
					$achadosTombo++;

					$carga->tombo                  = $tombo;
					$carga->mfn                    = $dob[0]['_id'];
					$carga->titulo                 = trim(preg_replace("/[ˆ<>]/i", "", $dob[0]['v40']['_']));
					if (array_key_exists('v25', $dob[0]))
					{
						if(count($dob[0]['v25']) > 1)
							$carga->nome               = trim($dob[0]['v25'][0]['_']);
						else
							$carga->nome               = trim($dob[0]['v25']['_']);
					}
					if (array_key_exists('v150', $dob[0]))
						$carga->cs                   = $dob[0]['v150']['_'];
					if (array_key_exists('v151', $dob[0]))
						$carga->estante              = $dob[0]['v151']['_'];
					if (array_key_exists('v152', $dob[0]))
						$carga->prateleira           = $dob[0]['v152']['_'];
					if (array_key_exists('v153', $dob[0]))
					{
						$parte = explode('-', $dob[0]['v153']['_']);
						$carga->numero               = $parte[0];
						if (!empty($parte[1]))
							$carga->digito             = $parte[1]; 
					}
					if (array_key_exists('v1', $dob[0]))
						$carga->classificacao        = $dob[0]['v1']['_'];
					if (array_key_exists('v2', $dob[0]))
						$carga->notacao              = $dob[0]['v2']['_'];
					if (array_key_exists('v139', $dob[0]))
					{
						if (array_key_exists('v138', $dob[0])) // Se também tem Tomo
							$carga->volume             = $dob[0]['v139']['_'] . ' ' . $dob[0]['v138']['_'];
						else
							$carga->volume             = $dob[0]['v139']['_'];
					}
					else
					{
						if (array_key_exists('v138', $dob[0])) // Tomo
						{
							$carga->volume             = $dob[0]['v138']['_'];
						}
						else
						{
							if (array_key_exists('v142', $dob[0])) // Parte
								$carga->volume           = $dob[0]['v142']['_'];
						}
					}
					if (array_key_exists('v50', $dob[0]))
						$carga->edicao               = $dob[0]['v50']['_'];
					if (array_key_exists('v70', $dob[0]))
						$carga->ano                  = $dob[0]['v70']['_'];

					// Exibir log
					echo "\n\033[34m" . 'ID: ' . $legadoCarga[$i]->id_carga . " ***************LOCALIZADO*PELO*TOMBO***************";
					echo "\nTombo Legado: " . $tombo;
					echo "\n------------";
					echo "\nTombo Achado: ";
					if (array_key_exists('v12', $dob[0]))
					{
						if(count($dob[0]['v12']) > 1)
							echo $dob[0]['v12'][0]['_'];
						else
							echo $dob[0]['v12']['_'];
					}
					if(array_key_exists('v10', $dob[0]))
					{
						if(count($dob[0]['v10']) > 1)
							echo '/' . $dob[0]['v10'][0]['_'];
						else
							echo '/' . $dob[0]['v10']['_'];

					}
					echo "\n------------";
					echo "\nTítulo Legado: " . mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
					echo "\n------------";
					echo "\nTítulo Achado: " . $carga->titulo;
					echo "\n------------";
					echo "\nNome Legado: ";
					if ($legadoCarga[$i]->osobrenome)
						echo mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');
					if ($legadoCarga[$i]->onome)
						echo ', ' . mb_convert_encoding($legadoCarga[$i]->onome, 'Windows-1252', 'auto');
					echo "\n------------";
					echo "\nNome Achado: " . $carga->nome;
					echo "\n**********************************************************\n\033[0m";


				} // FIM - Foi encontrada correspondência do tombo na DOB

				// Não foi encontrada correspondência do tombo na DOB ou forma encontrados VÁRIOS RESULTADOS
				else
				{
					// Vários Resultados
					if (count($dob) > 1)
					{
						echo "\n\033[41m\033[1;33m----------------------------------------------------------------------";
						echo "\nERRO!!! FOI encontrado mais que um resultado ao ser consultada o TOMBO";
						echo "\n----------------------------------------------------------------------";
						echo "\n----------------------------------------------------------------------\033[0m\n";
						print_r($legadoCarga[$i]);
						echo "\n----------------------------------------------------------------------";
						echo "\n----------------------------------------------------------------------\n";
						//dd($dob);
						print_r($dob);
						echo "\n----------------------------------------------------------------------";
						echo "\n----------------------------------------------------------------------\n";
					}

					$nao_achadosTombo++;
					$carga->tombo                  = $tombo_legado . ' (Legado t.n.l.)'; // Tombo não localizado
					$carga->titulo                 = mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
					// Autor
					if (isset($legadoCarga[$i]->osobrenome) && !empty($legadoCarga[$i]->osobrenome))
					{
						if (isset($legadoCarga[$i]->onome) && !empty($legadoCarga[$i]->onome))
							$carga->nome           = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto') . ', ' . mb_convert_encoding($legadoCarga[$i]->onome, 'Windows-1252', 'auto');
						else
							$carga->nome           = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');
					}
					if (isset($legadoCarga[$i]->cs) && (!empty($legadoCarga[$i]->cs) || $legadoCarga[$i]->cs != '0' || $legadoCarga[$i]->cs != 'NULL'))
						$carga->cs                   = mb_convert_encoding($legadoCarga[$i]->cs, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->estante) && (!empty($legadoCarga[$i]->estante) || $legadoCarga[$i]->estante != '0' || $legadoCarga[$i]->estante != 'NULL'))
						$carga->estante              = mb_convert_encoding($legadoCarga[$i]->estante, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->prateleira) && (!empty($legadoCarga[$i]->prateleira) || $legadoCarga[$i]->prateleira != '0' || $legadoCarga[$i]->prateleira != 'NULL'))
						$carga->prateleira           = mb_convert_encoding($legadoCarga[$i]->prateleira, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->numero) && (!empty($legadoCarga[$i]->numero) || $legadoCarga[$i]->numero != '0' || $legadoCarga[$i]->numero != 'NULL'))
						$carga->numero               = mb_convert_encoding($legadoCarga[$i]->numero, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->digito) && (!empty($legadoCarga[$i]->digito) || $legadoCarga[$i]->digito != '0' || $legadoCarga[$i]->digito != 'NULL'))
						$carga->digito               = mb_convert_encoding($legadoCarga[$i]->digito, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->classificacao) && (!empty($legadoCarga[$i]->classificacao) || $legadoCarga[$i]->classificacao != '0' || $legadoCarga[$i]->classificacao != 'NULL'))
						$carga->classificacao        = mb_convert_encoding($legadoCarga[$i]->classificacao, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->notacao) && (!empty($legadoCarga[$i]->notacao) || $legadoCarga[$i]->notacao != '0' || $legadoCarga[$i]->notacao != 'NULL'))
						$carga->notacao              = mb_convert_encoding($legadoCarga[$i]->notacao, 'Windows-1252', 'auto');
					if (isset($legadoCarga[$i]->volume) && (!empty($legadoCarga[$i]->vol) || $legadoCarga[$i]->vol != '0' || $legadoCarga[$i]->vol != 'NULL'))
						$carga->volume              = mb_convert_encoding($legadoCarga[$i]->vol, 'Windows-1252', 'auto');

					// Exibir log
					echo "\n\033[31m" . 'ID: ' . $legadoCarga[$i]->id_carga . "============NAO_LOCALIZADO_PELO_TOMBO============";
					echo "\nTombo Legado: " . $carga->tombo;
					echo "\n------------";
					echo "\nTítulo Legado: " . $carga->titulo;
					echo "\n------------";
					echo "\nNome Legado: " . $carga->nome;
					echo "\n------------";
					echo "\n=================================================\n\033[0m";


				} // FIM - Não foi encontrada correspondência do tombo na DOB

			} // FIM - Se o Tombo for um valor existe, procurar campos na DOB.

			// Não possui um valor existe ou válido para o Tombo
			else
			{
				// Localizar a Obra pela localização Fixa

				// A Consulta dependerá da existências dos campos no Legado
				$cs          = mb_convert_encoding($legadoCarga[$i]->cs, 'Windows-1252', 'auto');
				$estante     = mb_convert_encoding($legadoCarga[$i]->estante, 'Windows-1252', 'auto');
				$prateleira  = mb_convert_encoding($legadoCarga[$i]->prateleira, 'Windows-1252', 'auto');
				$numero_orig = mb_convert_encoding($legadoCarga[$i]->numero, 'Windows-1252', 'auto');
				$numero      = mb_convert_encoding($legadoCarga[$i]->numero, 'Windows-1252', 'auto');
				$digito      = mb_convert_encoding($legadoCarga[$i]->digito, 'Windows-1252', 'auto');
				if (!empty($digito) && $digito != 0)
					$numero = $numero . '-' . $digito;

				// Não possui Conjunto Suplementar
				if (empty($cs) || $cs == 'NULL' || $cs == '0')
				{
					$dob = DB::connection('mongodb')
							->collection('dob')
							->where('v151._', '=', "$estante")
							->where('v152._', '=', "$prateleira")
							->where('v153._', '=', "$numero")
							->where(function($query)
							{
								$query->where('v8._', '=', 'Livro')
											->orWhere('v8._', '=', 'Livro ')
											->orWhere('v8._', '=', 'livro')
											->orWhere('v8._', '=', 'Tese')
											->orWhere('v8._', '=', 'Folheto')
											->orWhere('v8._', '=', 'Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - obra rara')
											->orWhere('v8._', '=', ' Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - Obra Rara');
							})
							->whereNull('v150')
							->get();

					// Resultado da Consulta por Localização sem CS Positivo
					if (count($dob) === 1)
					{
						$achadosLocalizacao++;
						if (array_key_exists('v12', $dob[0]))
							if(count($dob[0]['v12']) > 1)
								$carga->tombo               = $dob[0]['v12'][0]['_'];
							else
								$carga->tombo               = $dob[0]['v12']['_'];
						$carga->mfn                     = $dob[0]['_id'];
						$carga->titulo                  = trim(preg_replace("/[ˆ<>]/i", "", $dob[0]['v40']['_']));
						if (array_key_exists('v25', $dob[0]))
						{
							if(count($dob[0]['v25']) > 1)
								$carga->nome                = trim($dob[0]['v25'][0]['_']);
							else
								$carga->nome                = trim($dob[0]['v25']['_']);
						}

						$carga->estante                 = $estante;
						$carga->prateleira              = $prateleira;
						$carga->numero                  = $numero_orig;
						if (!empty($digito))
							$carga->digito                = $digito;

						if (array_key_exists('v1', $dob[0]))
							$carga->classificacao        = $dob[0]['v1']['_'];
						if (array_key_exists('v2', $dob[0]))
							$carga->notacao              = $dob[0]['v2']['_'];
						if (array_key_exists('v139', $dob[0]))
						{
							if (array_key_exists('v138', $dob[0])) // Se também tem Tomo
								$carga->volume             = $dob[0]['v139']['_'] . ' ' . $dob[0]['v138']['_'];
							else
								$carga->volume             = $dob[0]['v139']['_'];
						}
						else
						{
							if (array_key_exists('v138', $dob[0])) // Tomo
							{
								$carga->volume             = $dob[0]['v138']['_'];
							}
							else
							{
								if (array_key_exists('v142', $dob[0])) // Parte
									$carga->volume           = $dob[0]['v142']['_'];
							}
						}
						if (array_key_exists('v50', $dob[0]))
							$carga->edicao               = $dob[0]['v50']['_'];
						if (array_key_exists('v70', $dob[0]))
							$carga->ano                  = $dob[0]['v70']['_'];

						// Exibir log
						echo "\n\033[1;34m" . 'ID: ' . $legadoCarga[$i]->id_carga . ' ////////////LOCALIZADO_PELA_LOCALIZAÇÃO_SEM_CS////////////';
						echo "\nLocalização Legada: ";
						if ($legadoCarga[$i]->cs)
							echo 'CS' . $legadoCarga[$i]->cs . ' / ';
						if ($legadoCarga[$i]->estante)
							echo 'E' . $legadoCarga[$i]->estante . ' / ';
						if ($legadoCarga[$i]->prateleira)
							echo 'P' . $legadoCarga[$i]->prateleira . ' / ';
						if ($legadoCarga[$i]->numero)
							echo 'N' . $legadoCarga[$i]->numero;
						if ($legadoCarga[$i]->digito)
							echo '-' . $legadoCarga[$i]->digito;
						echo "\n------------";
						echo "\nLocalização Achada: ";
						if(array_key_exists('v150', $dob[0]))
							echo 'CS' . $dob[0]['v150']['_'] . ' / ';
						if ($carga->estante)
							echo 'E' . $carga->estante . ' / ';
						if ($carga->prateleira)
							echo 'P' . $carga->prateleira . ' / ';
						if ($carga->numero)
							echo 'N' . $carga->numero;
						if ($carga->digito)
							echo '-' . $carga->digito;
						echo "\n------------";
						echo "\nTítulo Legado: " . mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						echo "\n------------";
						echo "\nTítulo Achado: " . $carga->titulo;
						echo "\n------------";
						echo "\nNome Legado: " . mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');;
						echo "\n------------";
						echo "\nNome Achado: " . $carga->nome;
						echo "\n------------";
						echo "\n" . '//////////////////////////////////////////////////////////' . "\n\033[0m";


					} // FIM - Resultado da Consulta por Localização sem CS Positivo

					// Resultado da Consulta por Localização sem CS NEGATIVO ou COM VÁRIOS RESULTADOS
					else
					{
						// Mais de um resultado possível na consulta
						if(count($dob) > 1)
						{
							echo "\n\033[41m\033[1;33m----------------------------------------------------------------------";
							echo "\nERRO!!! FOI encontrado mais que um resultado ao ser consultada a localização sem CS\n";
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\033[0m\n";
							print_r($legadoCarga[$i]);
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\n";
							//dd($dob);
							print_r($dob);
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\n";
						}

						$nao_achadosLocalizacao++;
						if (!empty($legadoCarga[$i]->tombo))
							$carga->tombo                = mb_convert_encoding($legadoCarga[$i]->tombo, 'Windows-1252', 'auto');
						else
							$carga->tombo                = ' (Legado s.cs.n.)';

						$carga->titulo                   = mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						// Autor
						if (!empty($legadoCarga[$i]->osobrenome))
						{
							if (!empty($legadoCarga[$i]->onome))
								$carga->nome             = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto') . ', ' . mb_convert_encoding($legadoCarga[$i]->onome, 'Windows-1252', 'auto');
							else
								$carga->nome             = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');
						}
						if (isset($legadoCarga[$i]->cs) && (!empty($legadoCarga[$i]->cs) && $legadoCarga[$i]->cs != '0' && $legadoCarga[$i]->cs != 'NULL'))
							$carga->cs                   = mb_convert_encoding($legadoCarga[$i]->cs, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->estante) && (!empty($legadoCarga[$i]->estante) && $legadoCarga[$i]->estante != '0' && $legadoCarga[$i]->estante != 'NULL'))
							$carga->estante              = mb_convert_encoding($legadoCarga[$i]->estante, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->prateleira) && (!empty($legadoCarga[$i]->prateleira) && $legadoCarga[$i]->prateleira != '0' && $legadoCarga[$i]->prateleira != 'NULL'))
							$carga->prateleira           = mb_convert_encoding($legadoCarga[$i]->prateleira, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->numero) && (!empty($legadoCarga[$i]->numero) && $legadoCarga[$i]->numero != '0' && $legadoCarga[$i]->numero != 'NULL'))
							$carga->numero               = mb_convert_encoding($legadoCarga[$i]->numero, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->digito) && (!empty($legadoCarga[$i]->digito) && $legadoCarga[$i]->digito != '0' && $legadoCarga[$i]->digito != 'NULL'))
							$carga->digito               = mb_convert_encoding($legadoCarga[$i]->digito, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->classificacao) && (!empty($legadoCarga[$i]->classificacao) && $legadoCarga[$i]->classificacao != '0' && $legadoCarga[$i]->classificacao != 'NULL'))
							$carga->classificacao        = mb_convert_encoding($legadoCarga[$i]->classificacao, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->notacao) && (!empty($legadoCarga[$i]->notacao) && $legadoCarga[$i]->notacao != '0' && $legadoCarga[$i]->notacao != 'NULL'))
							$carga->notacao              = mb_convert_encoding($legadoCarga[$i]->notacao, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->volume) && (!empty($legadoCarga[$i]->vol) && $legadoCarga[$i]->vol != '0' && $legadoCarga[$i]->vol != 'NULL'))
							$carga->volume              = mb_convert_encoding($legadoCarga[$i]->vol, 'Windows-1252', 'auto');

						// Exibir log
						echo "\n\033[1;35m" . 'ID: ' . $legadoCarga[$i]->id_carga .  '^^^^^^^^^^NAO_LOCALIZADO_PELA_LOCALIZAÇÃO_SEM_CS^^^^^^^^^^';
						echo "\nLocalização Legada: ";
						if ($legadoCarga[$i]->cs)
							echo 'CS' . $legadoCarga[$i]->cs . ' / ';
						if ($legadoCarga[$i]->estante)
							echo 'E' . $legadoCarga[$i]->estante . ' / ';
						if ($legadoCarga[$i]->prateleira)
							echo 'P' . $legadoCarga[$i]->prateleira . ' / ';
						if ($legadoCarga[$i]->numero)
							echo 'N' . $legadoCarga[$i]->numero;
						if ($legadoCarga[$i]->digito)
							echo '-' . $legadoCarga[$i]->digito;
						echo "\n------------";
						echo "\nTítulo Legado: " . mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						echo "\n------------";
						echo "\nNome Legado: " . mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');;
						echo "\n------------";
						echo "\n" . '^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^' . "\n\033[0m";

					} // FIM - Resultado da Consulta por Localização sem CS NEGATIVO
				}// FIM - Não possui Conjunto Suplementar

				// Possui Conjunto Suplementar
				else
				{
					$dob = DB::connection('mongodb')
							->collection('dob')
							->where('v150._', '=', "%$cs%")
							->where('v151._', '=', "%$estante%")
							->where('v152._', '=', "%$prateleira%")
							->where('v153._', '=', $numero)
							->where(function($query)
							{
								$query->where('v8._', '=', 'Livro')
											->orWhere('v8._', '=', 'Livro ')
											->orWhere('v8._', '=', 'livro')
											->orWhere('v8._', '=', 'Tese')
											->orWhere('v8._', '=', 'Folheto')
											->orWhere('v8._', '=', 'Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - obra rara')
											->orWhere('v8._', '=', ' Livro - Obra rara')
											->orWhere('v8._', '=', 'Livro - Obra Rara');
							})->get();

					// Resultado da Consulta por Localização com CS Positivo
					if (count($dob) === 1)
					{
						$achadosLocalizacao++;
						if (array_key_exists('v12', $dob[0]))
							if(count($dob[0]['v12']) > 1)
								$carga->tombo               = $dob[0]['v12'][0]['_'];
							else
								$carga->tombo               = $dob[0]['v12']['_'];
						$carga->mfn                     = $dob[0]['_id'];
						$carga->titulo                  = trim(preg_replace("/[ˆ<>]/i", "", $dob[0]['v40']['_']));
						if (array_key_exists('v25', $dob[0]))
						{
							if(count($dob[0]['v25']) > 1)
								$carga->nome                = trim($dob[0]['v25'][0]['_']);
							else
								$carga->nome                = trim($dob[0]['v25']['_']);
						}

						$carga->cs                      = $cs;
						$carga->estante                 = $estante;
						$carga->prateleira              = $prateleira;
						$carga->numero                  = $numero_orig;
						if (!empty($digito))
							$carga->digito                = $digito;

						if (array_key_exists('v1', $dob[0]))
							$carga->classificacao        = $dob[0]['v1']['_'];
						if (array_key_exists('v2', $dob[0]))
							$carga->notacao              = $dob[0]['v2']['_'];
						if (array_key_exists('v139', $dob[0]))
						{
							if (array_key_exists('v138', $dob[0])) // Se também tem Tomo
								$carga->volume             = $dob[0]['v139']['_'] . ' ' . $dob[0]['v138']['_'];
							else
								$carga->volume             = $dob[0]['v139']['_'];
						}
						else
						{
							if (array_key_exists('v138', $dob[0])) // Tomo
							{
								$carga->volume             = $dob[0]['v138']['_'];
							}
							else
							{
								if (array_key_exists('v142', $dob[0])) // Parte
									$carga->volume           = $dob[0]['v142']['_'];
							}
						}
						if (array_key_exists('v50', $dob[0]))
							$carga->edicao               = $dob[0]['v50']['_'];
						if (array_key_exists('v70', $dob[0]))
							$carga->ano                  = $dob[0]['v70']['_'];

						// Exibir log
						echo "\n\033[136m" . 'ID: ' . $legadoCarga[$i]->id_carga .  '############LOCALIZADO_PELA_LOCALIZAÇÃO_COM_CS############';
						echo "\nLocalização Legada: ";
						if ($legadoCarga[$i]->cs)
							echo 'CS' . $legadoCarga[$i]->cs . ' / ';
						if ($legadoCarga[$i]->estante)
							echo 'E' . $legadoCarga[$i]->estante . ' / ';
						if ($legadoCarga[$i]->prateleira)
							echo 'P' . $legadoCarga[$i]->prateleira . ' / ';
						if ($legadoCarga[$i]->numero)
							echo 'N' . $legadoCarga[$i]->numero;
						if ($legadoCarga[$i]->digito)
							echo '-' . $legadoCarga[$i]->digito;
						echo "\n------------";
						echo "\nLocalização Achada: ";
						if(array_key_exists('v150', $dob[0]))
							echo 'CS' . $dob[0]['v150']['_'] . ' / ';
						if ($carga->estante)
							echo 'E' . $carga->estante . ' / ';
						if ($carga->prateleira)
							echo 'P' . $carga->prateleira . ' / ';
						if ($carga->numero)
							echo 'N' . $carga->numero;
						if ($carga->digito)
							echo '-' . $carga->digito;
						echo "\n------------";
						echo "\nTítulo Legado: " . mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						echo "\n------------";
						echo "\nTítulo Achado: " . $carga->titulo;
						echo "\n------------";
						echo "\nNome Legado: " . mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');;
						echo "\n------------";
						echo "\nNome Achado: " . $carga->nome;
						echo "\n------------";
						echo "\n" . '##########################################################' . "\n\033[0m";

					} // FIM - Resultado da Consulta por Localização com CS Positivo

					// Resultado da Consulta por Localização com CS NEGATIVO
					else
					{
						// Possui mais de um resultado possível na consulta por localização com CS
						if(count($dob) > 1)
						{
							echo "\n\033[41m\033[1;33m----------------------------------------------------------------------";
							echo "\nERRO!!! FOI encontrado mais que um resultado ao ser consultada a localização com CS\n";
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\033[0m\n";
							print_r($legadoCarga[$i]);
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\n";
							//dd($dob);
							print_r($dob);
							echo "\n----------------------------------------------------------------------";
							echo "\n----------------------------------------------------------------------\n";
						}

						$nao_achadosLocalizacao++;

						if (isset($legadoCarga[$i]->tombo) && (!empty($legadoCarga[$i]->tombo) && $legadoCarga[$i]->tombo != '0' && $legadoCarga[$i]->tombo != 'NULL'))
							$carga->tombo                = mb_convert_encoding($legadoCarga[$i]->tombo, 'Windows-1252', 'auto');
						else
							$carga->tombo                = ' (Legado c.cs.n.)';

						$carga->titulo                   = mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						// Autor
						if (isset($legadoCarga[$i]->osobrenome) && !empty($legadoCarga[$i]->osobrenome))
						{
							if (isset($legadoCarga[$i]->onome) && !empty($legadoCarga[$i]->onome))
								$carga->nome             = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto') . ', ' . mb_convert_encoding($legadoCarga[$i]->onome, 'Windows-1252', 'auto');
							else
								$carga->nome             = mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');
						}
						if (isset($legadoCarga[$i]->cs) && (!empty($legadoCarga[$i]->cs) && $legadoCarga[$i]->cs != '0' && $legadoCarga[$i]->cs != 'NULL'))
							$carga->cs                   = mb_convert_encoding($legadoCarga[$i]->cs, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->estante) && (!empty($legadoCarga[$i]->estante) && $legadoCarga[$i]->estante != '0' && $legadoCarga[$i]->estante != 'NULL'))
							$carga->estante              = mb_convert_encoding($legadoCarga[$i]->estante, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->prateleira) && (!empty($legadoCarga[$i]->prateleira) && $legadoCarga[$i]->prateleira != '0' && $legadoCarga[$i]->prateleira != 'NULL'))
							$carga->prateleira           = mb_convert_encoding($legadoCarga[$i]->prateleira, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->numero) && (!empty($legadoCarga[$i]->numero) && $legadoCarga[$i]->numero != '0' && $legadoCarga[$i]->numero != 'NULL'))
							$carga->numero               = mb_convert_encoding($legadoCarga[$i]->numero, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->digito) && (!empty($legadoCarga[$i]->digito) && $legadoCarga[$i]->digito != '0' && $legadoCarga[$i]->digito != 'NULL'))
							$carga->digito               = mb_convert_encoding($legadoCarga[$i]->digito, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->classificacao) && (!empty($legadoCarga[$i]->classificacao) && $legadoCarga[$i]->classificacao != '0' && $legadoCarga[$i]->classificacao != 'NULL'))
							$carga->classificacao        = mb_convert_encoding($legadoCarga[$i]->classificacao, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->notacao) && (!empty($legadoCarga[$i]->notacao) && $legadoCarga[$i]->notacao != '0' && $legadoCarga[$i]->notacao != 'NULL'))
							$carga->notacao              = mb_convert_encoding($legadoCarga[$i]->notacao, 'Windows-1252', 'auto');
						if (isset($legadoCarga[$i]->vol) && (!empty($legadoCarga[$i]->vol) && $legadoCarga[$i]->vol != '0' && $legadoCarga[$i]->vol != 'NULL'))
							$carga->volume              = mb_convert_encoding($legadoCarga[$i]->vol, 'Windows-1252', 'auto');

						// Exibir log
						echo "\n\033[1;35m" . 'ID: ' . $legadoCarga[$i]->id_carga . '>>>>>>>>>>NAO_LOCALIZADO_PELA_LOCALIZAÇÃO_COM_CS>>>>>>>>>>';
						echo "\nLocalização Legada: ";
						if ($legadoCarga[$i]->cs)
							echo 'CS' . $legadoCarga[$i]->cs . ' / ';
						if ($legadoCarga[$i]->estante)
							echo 'E' . $legadoCarga[$i]->estante . ' / ';
						if ($legadoCarga[$i]->prateleira)
							echo 'P' . $legadoCarga[$i]->prateleira . ' / ';
						if ($legadoCarga[$i]->numero)
							echo 'N' . $legadoCarga[$i]->numero;
						if ($legadoCarga[$i]->digito)
							echo '-' . $legadoCarga[$i]->digito;
						echo "\n------------";
						echo "\nTítulo Legado: " . mb_convert_encoding($legadoCarga[$i]->titulo, 'Windows-1252', 'auto');
						echo "\n------------";
						echo "\nNome Legado: " . mb_convert_encoding($legadoCarga[$i]->osobrenome, 'Windows-1252', 'auto');;
						echo "\n------------";
						echo "\n" . '>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>' . "\n\033[0m";

					} // FIM - Resultado da Consulta por Localização com CS NEGATIVO

				} // FIM - Possui Conjunto Suplementar

				unset($cs);
				unset($estante);
				unset($prateleira);
				unset($numero);
				unset($numero_orig);
				unset($digito);

			} // FIM - Não possui um valor existe ou válido para o Tombo

			// Definir as datas
			// Data da Carga
			if (isset($legadoCarga[$i]->stampinicial) && !empty($legadoCarga[$i]->stampinicial))
				$carga->data_carga = converteTimestamp($legadoCarga[$i]->stampinicial);
			// Data da Baixa
			if (isset($legadoCarga[$i]->stampfinal) && !empty($legadoCarga[$i]->stampfinal))
				$carga->data_baixa = converteTimestamp($legadoCarga[$i]->stampfinal);
			// Data da Baixa
			if (isset($legadoCarga[$i]->stampcobranca) && !empty($legadoCarga[$i]->stampcobranca))
				$carga->data_cobranca = converteTimestamp($legadoCarga[$i]->stampcobranca);

			// Definir os funcionários
			if (isset($legadoCarga[$i]->funcinicial) && !empty($legadoCarga[$i]->funcinicial))
				$carga->funcionarios_carga_id = mb_convert_encoding($legadoCarga[$i]->funcinicial, 'Windows-1252', 'auto');
			if (isset($legadoCarga[$i]->funcfinal) && !empty($legadoCarga[$i]->funcfinal))
				$carga->funcionarios_baixa_id = mb_convert_encoding($legadoCarga[$i]->funcfinal, 'Windows-1252', 'auto');

			// Relacionamentos Legados
			if (isset($legadoCarga[$i]->id_autopredio) && !empty($legadoCarga[$i]->id_autopredio))
				$carga->autoridades_predios_id = mb_convert_encoding($legadoCarga[$i]->id_autopredio, 'Windows-1252', 'auto');
			if (isset($legadoCarga[$i]->destino) && !empty($legadoCarga[$i]->destino))
				$carga->destinatarios_id = mb_convert_encoding($legadoCarga[$i]->destino, 'Windows-1252', 'auto');

			// Pessoas envolvidas na carga - Retirante - Rolicitante - Observação
			// solicitante
			//retirante
			if (isset($legadoCarga[$i]->obs) && !empty($legadoCarga[$i]->obs))
				$carga->observacao = mb_convert_encoding($legadoCarga[$i]->obs, 'Windows-1252', 'auto');

			// Definir O tipo de Solicitação para o legado
			$carga->tipos_solicitacoes_id = 1;

			// Realiza o salvamento do registro
			$carga->save();

			// Atualizar Base Legada com Valores Temporários
			$atualizarLegadoAutoPredio = DB::connection('legado')->table('cargactrl')->where('id_carga', '=', $legadoCarga[$i]->id_carga)->update(array('id_carga' => $carga->id+10000));

			unset($carga);
			unset($dob);
			//unset($atualizarLegadoAutoPredio);
		} // FIM - Looping para resgatar todas as cargas legadas

		unset($legadoCarga);
		echo "\n" . "*** Tombo.";
		echo "\n" . "         Achados: " . $achadosTombo;
		echo "\n" . "     Não achados: " . $nao_achadosTombo;
		echo "\n" . "*** Localização.";
		echo "\n" . "         Achados: " . $achadosLocalizacao;
		echo "\n" . "     Não achados: " . $nao_achadosLocalizacao;

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
		echo "\n ==> A tabela de Carga foi semeada em ".$totaltime." segundos. \n";

		$this->command->info('CargaSeeder - Tabela de Carga semeada!');

	}

}
