<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests;
use App\Http\Requests\UsuarioEntrarRequest;
use App\Http\Requests\UsuarioCadastrarRequest;
use App\Http\Requests\UsuarioEditarRequest;
use App\Http\Requests\AlterarSenhaRequest;

// Facades
use Cartalyst\Sentry\Facades\Laravel\Sentry;

// Models
use App\User;

class UsuariosController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	public function getEntrar()
	{
		Sentry::logout();
		return view('usuario.entrar');
	}

	public function postEntrar(UsuarioEntrarRequest $request)
	{
		try
		{
			$credenciais = array(
				'email'    => $request->input('email'),
				'password' => $request->input('password')
				);
			$lembrar = ($request->input('remember') == 'on') ? true : false;
			$user = Sentry::authenticate($credenciais, $lembrar);
		}
		catch (\Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
			return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'A senha está incorreta.');
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário (e-mail) está incorreto.');
		}
		catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário não está ativo.');
		}
		catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
			return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário está suspenso por excesso de erros na senha.');
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
			return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário está banido.');
		}
		return redirect()->route('desktop');
	}

	public function getListar()
	{
		$usuarios = User::all();
		return view('usuario.listar', compact('usuarios'));
	}

	public function getCadastrar()
	{
		return view('usuario.cadastrar');
	}

	public function postCadastrar(UsuarioCadastrarRequest $request)
	{
		$input = $request->all();
		$input = array_except($input, array('password_confirmation'));
		$input = array_add($input, 'activated', 'false');
		try
		{
			$usuario = Sentry::createUser($input);
		}
		catch (\Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
			return redirect()->route('usuario.cadastrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O login é exigido.');
		}
		catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
			return redirect()->route('usuario.cadastrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'A senha é exigida.');
		}
		catch (\Cartalyst\Sentry\Users\UserExistsException $e)
		{
			return redirect()->route('usuario.cadastrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário já existe.');
		}
		catch (\Cartalyst\Sentry\Users\GroupNotFoundException $e)
		{
			return redirect()->route('usuario.cadastrar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O grupo não existe.');
		}

		return redirect()->route('usuario.entrar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'O usuário foi criado com sucesso.');
	}

	public function getSair()
	{
		Sentry::logout();
		return redirect()->route('usuario.entrar');
	}

	public function getEditar($id)
	{
		$usuario = User::findOrFail($id);
		$todosgrupos = Sentry::findAllGroups();
		$grupos = [];
		foreach ($todosgrupos as $key => $grupo) {
			$grupos[$grupo->id] = $grupo->name;
		}
		return view('usuario.editar', compact('usuario', 'grupos'));
	}


	public function postEditar($id, UsuarioEditarRequest $request)
	{

		$usuario = Sentry::findUserById($id);
		$usuario->first_name = $request->first_name;
		$usuario->last_name = $request->last_name;
		$usuario->email = $request->email;
		$usuario->matricula = $request->matricula;
		if ($request->ativado)
			$usuario->activated = $request->ativado;
		$usuario->groups()->sync($request->input('grupos'));

		if ($usuario->save())
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'O usuário foi atualizado com sucesso.');
		}
		
	}

	public function getApagar($id)
	{
		try
		{
			$throttle = Sentry::findThrottlerByUserId($id);
			$throttle->ban();
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário não foi encontrado para ser removido.');
		}
		return redirect()->route('usuario.listar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'O usuário foi removido com sucesso.');
	}

	public function getReativar($id)
	{
		try
		{
			$throttle = Sentry::findThrottlerByUserId($id);
			$throttle->unBan();
		}
		catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário não foi encontrado para ser reativado.');
		}
		return redirect()->route('usuario.listar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'O usuário foi reativado com sucesso.');
	}

	public function getSuspender($id)
	{
		$usuario = Sentry::findThrottlerByUserId($id);
		$usuario->suspend();
		return redirect()->route('usuario.listar')
						->with('tipo_message', 'Perigo')
						->with('message', 'O usuário foi suspenso com sucesso.');
	}

	public function getLiberar($id)
	{
		$usuario = Sentry::findThrottlerByUserId($id);
		$usuario->unsuspend();
		return redirect()->route('usuario.listar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'O usuário foi liberado com sucesso.');
	}

	public function getSenha()
	{
		return view('usuario.senha');
	}

	public function postSenha(AlterarSenhaRequest $request)
	{
		$usuario = Sentry::getUser();
		$usuario->password = $request->input('password');
		$usuario->save();
		return redirect()->route('desktop')
						->with('tipo_message', 'Sucesso')
						->with('message', 'Senha Alterada.');
	}

	public function getResetar($id)
	{
		$usuario = Sentry::findUserById($id);
		$usuario->password = $usuario->matricula;
		$usuario->save();
		return redirect()->route('usuario.listar')
						->with('tipo_message', 'Sucesso')
						->with('message', 'Senha resetada com sucesso. Avisar que a senha foi modificada para a Matrícula. Avisar, igualmente, que deverá ser alterada no primeiro login.');
	}

}