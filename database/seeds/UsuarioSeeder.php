<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class UsuarioSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

		// ID 1 - Grupo Administrador 
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Administrador',
					'permissions' => array(
						'admin'       => 1,
						'usuario' => 1,
						'carga' => 1,
						'autoridade'   => 1,
						'obras' => 1,
						'predios' => 1,
						'telefones' => 1,
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 2 - Usuario
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Usuário',
					'permissions' => array(
						'desktop'   => 1,
						'links'     => 1
					)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 3 - Grupo Listar Cargas
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Listar Carga',
					'permissions' => array(
						'carga.listar'   => 1,
						'carga.exibir'   => 1,
						'carga.imprimir' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 4 - Grupo de Realizar Cargas
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Realizar Carga',
					'permissions' => array(
						'carga.realizar' => 1,
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 5 - Grupo de Baixar Cargas
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Realizar Baixa',
					'permissions' => array(
						'carga.baixar' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 6 - Grupo de Realizar Cobranças
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Realizar Cobrança',
					'permissions' => array(
						'carga.cobrar' => 1,
						'carga.renovar' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 7 - Grupo de Administrar Cargas
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Administrar Cargas',
					'permissions' => array(
						'carga.editar' => 1,
						'carga.apagar' => 1,
						'carga.reativar' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 8 - Grupo de Administrar Autoridades
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Administrar Autoridades',
					'permissions' => array(
						'autoridade.cadastrar' => 1,
						'autoridade.editar'    => 1,
						'autoridade.apagar'    => 1,
						'autoridade.reativar'  => 1,
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 9 - Grupo de Administrar Autoridades
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Listar Autoridades',
					'permissions' => array(
						'autoridade.api'   => 1,
						'autoridade.apitabela' => 1,
						'autoridade.exibir'   => 1,
						'autoridade.listar' => 1,
						'autoridade.imagem' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}


		// ID 10 - Grupo de Administrar Prédios
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Administrar Prédios',
					'permissions' => array(
						'predios' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 11 - Grupo de Administrar Telefones
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Administrar Telefones',
					'permissions' => array(
						'telefones' => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}

		// ID 12 - Grupo de Administrar Usuários
		try
		{
			$group = Sentry::createGroup(array(
					'name'    => 'Grupo de Administrar Usuários',
					'permissions' => array(
						'usuario.listar'   => 1,
						'usuario.editar'   => 1,
						'usuario.apagar'   => 1,
						'usuario.reativar' => 1,
						'usuario.grupos'   => 1
						)
				));
		}
		catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
		{
			echo 'O Grupo já existe.';
		}


		// Semear os Usuários Legados

		$legadoUsuarios = DB::connection('legado')
										->table('usuario')
										->orderby('id_usuario', 'asc')
										->get();

		foreach ($legadoUsuarios as $legadoUsuario) {
			$nome  = mb_convert_encoding($legadoUsuario->nome, 'Windows-1252', 'auto');
			$email = $legadoUsuario->login . '@biblioteca.br';
			if ($legadoUsuario->nivel == '0')
				$activated = false;
			else
				$activated = true;
			$samba = 0;

			// nome
			try
			{
				$usuario = Sentry::createUser(array(
					'first_name' => $nome,
					'email'      => $email,
					'samba'      => $samba,
					'password'   => $legadoUsuario->nosenha,
					'activated'  => $activated
					));
				$grupo = Sentry::findGroupById(2);
				$usuario->addGroup($grupo);
			}
			catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
			{
				echo 'O login é exigido.';
			}
			catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
			{
				echo 'A senha é exigida.';
			}
			catch (Cartalyst\Sentry\Users\UserExistsException $e)
			{
				echo 'O usuário já existe.';
			}
			catch (Cartalyst\Sentry\Users\GroupNotFoundException $e)
			{
				echo 'O grupo não existe.';
			}

		}

		// Acesso Inicial para Usuário responsável por gerir Usuários
		$grupo = Sentry::findGroupById(12);
		$usuario = Sentry::findUserById(1);
		$usuario->addGroup($grupo);

		$this->command->info('UsuarioSeeder - Tabela de usuários semeada!');

	}

}
