<?php namespace App\Http\Middleware;

use Closure;
use Sentry;

class SentryInGroup {

		/**
	 * Sentry - Check if user is in group/groups
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$actions = $request->route()->getAction();

		if (array_key_exists("inGroup", $actions)) 
		{
			$groups = $actions['inGroup'];

			try
			{
				$user = Sentry::getUser();

				if ( ! $user->isSuperUser() )
				{
					$count = 0;

					foreach ($groups as $g)
					{
						$group = Sentry::findGroupByName($g);
					 
						if ($user->inGroup($group))
						{
							$count++;
						}	
					}
					
					if ($count === 0)
					{
						return redirect()->route('desktop')
								->with('tipo_message', 'Aviso')
								->with('message', 'Você não tem acesso para visualizar esta página (Grupo).');
					}
				}
				
			}
			catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
			{
				return redirect()->route('usuario.entrar')
								->with('tipo_message', 'Perigo')
								->with('message', 'Você não está logado.');
			}
			 
			catch (\Cartalyst\Sentry\Groups\GroupNotFoundException $e)
			{
				return redirect()->route('usuario.entrar')
								->with('tipo_message', 'Perigo')
								->with('message', 'Você não está logado.');
			}		
		}		

		return $next($request);
	}

}