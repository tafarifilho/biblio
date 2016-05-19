<?php namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

// Facades
use Cartalyst\Sentry\Facades\Laravel\Sentry;

abstract class Controller extends BaseController {

	use DispatchesCommands, ValidatesRequests;

	protected $usuario;
	protected $usuarioAtual;

	public function __construct()
	{
		$this->usuario = $this->usuarioAtual = Sentry::getUser();
	}

}
