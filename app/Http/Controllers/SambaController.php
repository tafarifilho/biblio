<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Http\Requests\SambaRequest;
use App\Http\Requests\SambaGroupRequest;
use App\Http\Requests\SambaGrupoUsuarioRequest;

use Symfony\Component\Process\Process;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class SambaController extends Controller {

	public function getGrupo()
	{
		// Listar Grupos
		$listGrupos = new Process('sudo /bin/cat /etc/group | cut -d ":" -f 1');
		$listGrupos->run();
		$grupos = array_filter(explode("\n" , $listGrupos->getOutput()));
		// Quantidade de Grupos do Sistema Operacional que devem ser ocultados
		$grupos = array_slice($grupos, 53);
		return view('samba.grupo', compact('grupos'));
	}

	public function postGrupo(SambaGroupRequest $request)
	{
		// Adicionar Grupo
		if($request->input('grupo'))
		{
			$addGrupo = new Process('sudo /usr/sbin/groupadd ' . $request->input('grupo'));
			$addGrupo->run();
			if (!$addGrupo->isSuccessful())
			{
				return redirect()->route('samba.grupo')
							->with('tipo_message', 'Perigo')
							->with('message', $addGrupo->getErrorOutput());
			}
			return redirect()->route('samba.grupo')
						->with('tipo_message', 'Sucesso')
						->with('message', 'Grupo Samba cadastrado com sucesso: ' . $request->input('grupo'));
		}
	}

	public function getGrupoUsuario($id)
	{
		// Usuário
		$usuario = Sentry::findUserById($id);
		$usuario_explodido = explode("@", $usuario->email);
		$login = $usuario_explodido[0];

		// Listar Grupos
		$listGrupos = new Process('sudo /bin/cat /etc/group | cut -d ":" -f 1');
		$listGrupos->run();
		$grupos = array_filter(explode("\n", $listGrupos->getOutput()));
		$grupos = array_slice($grupos, 54);

		// Listar Grupos do Usuário
		$listGruposUsuarios = new Process('sudo /usr/bin/groups ' . $login . ' | cut -d ":" -f 2');
		$listGruposUsuarios->run();
		if ($listGruposUsuarios->getOutput())
			$gruposUsuarios = $listGruposUsuarios->getOutput();
		else
			$gruposUsuarios = 'Nenhum grupo cadastrado.';

		return view('samba.grupousuario', compact('grupos', 'usuario', 'gruposUsuarios'));

	}

	public function postGrupoUsuario($id, SambaGrupoUsuarioRequest $request)
	{
		// Usuário
		$usuario = Sentry::findUserById($id);
		$usuario_explodido = explode("@", $usuario->email);
		$login = $usuario_explodido[0];

		// Listar Grupos
		$listGrupos = new Process('sudo /bin/cat /etc/group | cut -d ":" -f 1');
		$listGrupos->run();
		$grupos = array_filter(explode("\n", $listGrupos->getOutput()));
		$grupos = array_slice($grupos, 54);

		$gruposUsuario = '';
		$contador = 1;

		// Serializar os Grupos passados pelo Input
		foreach ($request->input('grupos') as $key => $grupo) {
			if ($contador == 1)
			{
				$gruposUsuario = $grupos[$grupo];
				$contador++;
			}
			else
				$gruposUsuario = $gruposUsuario . ',' . $grupos[$grupo];
		}

		// Adicionar Grupo ao Usuário
		$addGrupoUsuario = new Process('sudo usermod -G ' . $gruposUsuario . ' ' . $login);
		$addGrupoUsuario->run();

		// Falha ao Adicionar Grupo ao Usuário
		if (!$addGrupoUsuario->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $addGrupoUsuario->getErrorOutput());
		}
		// Resultado de Sucesso
		return redirect()->route('usuario.listar')
					->with('tipo_message', 'Sucesso')
					->with('message', 'Grupo(s) vinculados ao usuário com sucesso.');
	}

	public function getGrupoApagar($grupo)
	{
		// Remover Grupo do Linux
		$comandoRemoverGrupo = 'sudo /usr/sbin/groupdel ' . $grupo;

		$removerGrupo = new Process($comandoRemoverGrupo);
		$removerGrupo->run();

		// Falha ao Remover o Grupo do Linux
		if (!$removerGrupo->isSuccessful())
		{
			return redirect()->route('samba.grupo')
						->with('tipo_message', 'Perigo')
						->with('message', $removerGrupo->getErrorOutput());
		}

		// Resultado de Sucesso
		return redirect()->route('samba.grupo')
					->with('tipo_message', 'Sucesso')
					->with('message', 'Grupo removido com sucesso!');
	}

	public function getCriarUsuario($id)
	{
		// Listar Usuários Samba
		$listUsuarios = new Process('sudo /bin/cat /etc/passwd | cut -d ":" -f 1');
		$listUsuarios->run();
		$usuarios = array_filter(explode("\n" , $listUsuarios->getOutput()));

		// Usuário do Banco de dados
		$usuario = Sentry::findUserById($id);
		$usuario_explodido = explode("@", $usuario->email);
		$login = $usuario_explodido[0];
		$password = $usuario->matricula;
		$first_name = $usuario->first_name;
		$last_name = $usuario->last_name;

		// Adicionar Usuário no Linux

		// -N -> Não cria grupo próprio com o nome do usuário
		// -p -> Senha
		// -c -> Comentário. Utilizado como Nome Completo
		// -s -> Sem login no sistema
		// -g -> Vincular a um Grupo
		// -m -> Cria um diretório Home padrão

		$comandoAdicionarUsuario = 'sudo /usr/sbin/useradd -N -p ' . $password . ' -c "' . $first_name . ' ' . $last_name . '" -s /usr/sbin/nologin -g Funcionarios -m -d /home/Samba/homes/' . $login . ' ' . $login;

		$adicionarUsuario = new Process($comandoAdicionarUsuario);
		$adicionarUsuario->run();

		// Falha ao Cadastrar o Usuário no Linux
		if (!$adicionarUsuario->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $adicionarUsuario->getErrorOutput());
		}

		// Adicionar Usuário ao Samba

		// -a -> Adicionar ao arquivo local de usuários do Samba. O usuário deve estar no sistema
		// -s -> Entra o usuário em silênio. Necessário para passar as senha de forma inline
		$comandoAdicionarUsuarioSamba = '(echo ' . $password . ' ; echo ' . $password . ') | sudo /usr/bin/smbpasswd -a -s ' . $login;

		$adicionarUsuarioSamba = new Process($comandoAdicionarUsuarioSamba);
		$adicionarUsuarioSamba->run();

		// Falha ao Cadastrar o Usuário no Samba
		if (!$adicionarUsuarioSamba->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $adicionarUsuarioSamba->getErrorOutput());
		}

		// Definir como usuário criado
		$usuario->samba = 1;
		$usuario->save();

		// Resultado de Sucesso
		return redirect()->route('usuario.listar')
					->with('tipo_message', 'Sucesso')
					->with('message', 'Usuário Samba criado com sucesso!');

	}

	public function getApagarUsuario($id)
	{
		// Usuário do Banco de dados
		$usuario = Sentry::findUserById($id);
		$usuario_explodido = explode("@", $usuario->email);
		$login = $usuario_explodido[0];

		// Apagar Usuário do Samba
		$comandoApagaUsuarioSamba = 'sudo /usr/bin/smbpasswd -x ' . $login;

		$apagaUsuarioSamba = new Process($comandoApagaUsuarioSamba);
		$apagaUsuarioSamba->run();

		// Falha ao Apagar o Usuário no Samba
		if (!$apagaUsuarioSamba->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $apagaUsuarioSamba->getErrorOutput());
		}

		// Apagar Usuário do Linux
		$comandoApagaUsuario = 'sudo /usr/sbin/userdel -f -r ' . $login;

		$apagaUsuario = new Process($comandoApagaUsuario);
		$apagaUsuario->run();

		// Falha ao Apagar o Usuário no Linux
		if (!$apagaUsuario->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $apagaUsuario->getErrorOutput());
		}

		// Definir como usuário sem acesso ao Samba
		$usuario->samba = 0;
		$usuario->save();

		// Resultado de Sucesso
		return redirect()->route('usuario.listar')
					->with('tipo_message', 'Sucesso')
					->with('message', 'Usuário Samba apagado com sucesso!');

	}

	public function getSenha()
	{
		return view('samba.senha');
	}

	public function postSenha(SambaRequest $request)
	{
		// Usuário do Banco de dados
		$usuario = Sentry::getUser();
		$usuario_explodido = explode("@", $usuario->email);
		$login = $usuario_explodido[0];
		$password = $request->password;

		// Alterar Senha do Linux
		$comandoAlteraSenhaLinux = '(echo ' . $password . ' ; echo ' . $password . ') | sudo /usr/bin/passwd ' . $login;

		$alteraSenhaLinux = new Process($comandoAlteraSenhaLinux);
		$alteraSenhaLinux->run();

		// Falha ao Alterara a Senha no Linux
		if (!$alteraSenhaLinux->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $alteraSenhaLinux->getErrorOutput());
		}

		// Alterar Senha do Samba
		$comandoAlteraSenhaSamba = '(echo ' . $password . ' ; echo ' . $password . ') | sudo /usr/bin/smbpasswd -s ' . $login;

		$alteraSenhaSamba = new Process($comandoAlteraSenhaSamba);
		$alteraSenhaSamba->run();

		// Falha ao Alterar a Senha no Samba
		if (!$alteraSenhaSamba->isSuccessful())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', $alteraSenhaSamba->getErrorOutput());
		}

		// Resultado de Sucesso
		return redirect()->route('desktop')
					->with('tipo_message', 'Sucesso')
					->with('message', 'Senha do Samba alterada com sucesso!');

	}

}
