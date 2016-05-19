<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\AutoridadeTipo;
use App\Autoridade;

class AutoridadeTipo extends Model {

	use SoftDeletes;

	protected $table = 'autoridades_tipos';

	protected $fillable = array(
		'tipo',
		'tratamento',
		'abreviado',
		'prazo'
		);

	public function autoridade()
	{
		// Model, foreign, local
		return $this->hasMany('App\Autoridade', 'autoridades_tipos_id', 'id');
	}

	public function scopeApagados ($query)
	{
		$query->withTrashed();
	}

}
