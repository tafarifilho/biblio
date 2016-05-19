<?php

/**
 *
 * Desabilitar a checagem de chaves externar temporariamente
 * SET GLOBAL foreign_key_checks=0;
 *
 */
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		//$this->call('UserTableSeeder');
		$this->call('PredioSeeder');
		$this->call('AutoridadeTipoSeeder');
		$this->call('AutoridadeSeeder');
		$this->call('AutoridadePredioSeeder');
		$this->call('AutoridadeTelefoneSeeder');
		$this->call('DestinatarioSeeder');
		$this->call('TipoSolicitacaoSeeder');
		$this->call('CargaSeeder');
		$this->call('ControleCargaSeeder');
		$this->call('LegadoSeeder');
		$this->call('UsuarioSeeder');
	}

}
