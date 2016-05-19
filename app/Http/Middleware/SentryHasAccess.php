<?php namespace App\Http\Middleware;

use Closure;
use Sentry;

class SentryHasAccess {

	/**
	 * Sentry - Check role permission
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$actions = $request->route()->getAction();

		if (array_key_exists('hasAccess', $actions)) 
		{
			$permission = $actions['hasAccess'];
		
			try
			{
				$user = Sentry::getUser();
			 
				if ( ! $user->hasAccess($permission))
				{
					return redirect()->route('desktop')
								->with('tipo_message', 'Aviso')
								->with('message', 'Você não tem acesso para visualizar esta página.');
				}
			}
			catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return redirect()->route('usuario.entrar')
								->with('tipo_message', 'Perigo')
								->with('message', 'Você não está logado.');

			}
		}

		return $next($request);
	}
}
