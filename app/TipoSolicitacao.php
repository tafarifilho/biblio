<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\AutoridadeTipo;
use App\Autoridade;

class TipoSolicitacao extends Model {

	use SoftDeletes;

	protected $table = 'tipos_solicitacoes';

	protected $fillable = array(
		'tipo',
		);

	public static $rules = array(
		'tipo'    =>   'required|min:2',
		);

	public function carga()
	{
		// Model, foreign, local
		return $this->hasMany('App\Carga', 'tipos_solicitacoes_id', 'id');
	}

}
