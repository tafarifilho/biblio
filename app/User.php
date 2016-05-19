<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Models
use App\Carga;

// Facades
use Cartalyst\Sentry\Facades\Laravel\Sentry;

class User extends Model {

	use SoftDeletes;
	
	protected $table = 'users';

	public function carga()
	{
		// Model, foreign, local
		return $this->hasMany('App\Carga', 'funcionarios_carga_id', 'id');
	}

	public function baixa()
	{
		// Model, foreign, local
		return $this->hasMany('App\Carga', 'funcionarios_baixa_id', 'id');
	}

	public function controle()
	{
		// Model, foreign, local
		return $this->hasMany('App\CargaControle', 'funcionarios_id', 'id');
	}

	public function gruposId()
	{
		$usuario = Sentry::findUserById($this->id);
		$groups = $usuario->getGroups();
		$grupos = [];
		foreach ($groups as $grupo) {
			$grupos[] = $grupo->id;
		}
		return $grupos;
	}
	public function gruposNomes()
	{
		$usuario = Sentry::findUserById($this->id);
		$groups = $usuario->getGroups();
		$grupos = [];
		foreach ($groups as $grupo) {
			$grupos[] = $grupo->name;
		}
		return $grupos;
	}

	public function estaRemovido()
	{
		$throttle = Sentry::findThrottlerByUserId($this->id);
		if ($throttle->isBanned())
			return true;
		else
			return false;
	}

	public function estaSuspenso()
	{
		$throttle = Sentry::findThrottlerByUserId($this->id);
		if ($throttle->isSuspended())
			return true;
		else
			return false;
	}

	public function estaInativo()
	{
		$usuario = Sentry::findUserById($this->id);
		if ($usuario->activated == 1)
			return false;
		else
			return true;
	}

	public function estaNoSamba()
	{
		if ($this->samba == 1)
			return true;
		else
			return false;
	}

}
