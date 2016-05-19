<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Carga;
use App\ControleCarga;

class ControleCarga extends Model {

	use SoftDeletes;

	protected $table = 'controles_cargas';

	//public $timestamps = false;

	protected $fillable = array(
		'cargas_id', 
		'funcionarios_id', 
		'controle'
		);

	public static $rules = array(
		'cargas_id'        =>           'required|min:1',
		'funcionarios_id'  =>           'required|min:1',
		'controle'         => 'sometimes|required|min:2'
		);

	public function carga()
	{
		return $this->belongsTo('App\Carga', 'cargas_id', 'id');
	}

	public function funcionario()
	{
		// Model, foreign, local
		return $this->belongsTo('App\User', 'funcionarios_id', 'id');
	}

}
