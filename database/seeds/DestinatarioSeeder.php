<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Destinatario;

class DestinatarioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// A inserção será manual em virtude da mudança na estrutura da tabela

		// Criado os novos registros Predio

		// Enviado para Gabinete
		$destinatario = new Destinatario;
		$destinatario->destinatario = 'Enviada para Gabinete';
		$destinatario->save();
		// Atualizar a tabela Destintarios Legada com os novos IDs
		$atualizarLegadoDestinatario = DB::connection('legado')->table('carga')->where('destino', '=', 2)->update(array('destino' => $destinatario->id+10000));
		unset($destinatario);
		unset($atualizarLegadoDestinatario);

		// Retirada por Pessoa Autorizada
		$destinatario = new Destinatario;
		$destinatario->destinatario = 'Retirada por Pessoa Autorizada';
		$destinatario->save();
		// Atualizar a tabela Destintarios Legada com os novos IDs
		$atualizarLegadoDestinatario = DB::connection('legado')->table('carga')->where('destino', '=', 5)->update(array('destino' => $destinatario->id+10000));
		unset($destinatario);
		unset($atualizarLegadoDestinatario);

		// Retirada pela Autoridade
		$destinatario = new Destinatario;
		$destinatario->destinatario = 'Retirada pela Autoridade';
		$destinatario->save();
		// Atualizar a tabela Destintarios Legada com os novos IDs
		$atualizarLegadoDestinatario = DB::connection('legado')->table('carga')->where('destino', '=', 1)->update(array('destino' => $destinatario->id+10000));
		unset($destinatario);
		unset($atualizarLegadoDestinatario);

		// Enviado para Outra Autoridade
		$destinatario = new Destinatario;
		$destinatario->destinatario = 'Enviada para Outra Autoridade';
		$destinatario->save();
		// Atualizar a tabela Destintarios Legada com os novos IDs
		// Atualização será realizada no Seed da Carga
		unset($destinatario);

		// Enviada para a Residência
		$destinatario = new Destinatario;
		$destinatario->destinatario = 'Enviada para a Residência';
		$destinatario->save();
		// Atualizar a tabela Destintarios Legada com os novos IDs
		$atualizarLegadoDestinatario = DB::connection('legado')->table('carga')->where('destino', '=', 6)->update(array('destino' => $destinatario->id+10000));
		unset($destinatario);
		unset($atualizarLegadoDestinatario);

		$this->command->info('DestinarioSeeder - Tabela de Destinatários semeada!');
	}

}
