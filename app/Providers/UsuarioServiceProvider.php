<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class UsuarioServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->composer('*', function($view){
			$view->with('usuarioAtual', Sentry::getUser());
		});
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

}
