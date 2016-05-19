<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Predio;
use App\Autoridade;
use App\AutoridadePredio;

class AutoridadePredio extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'autoridades_predios';

	protected $fillable = array(
		'autoridades_id', 
		'predios_id', 
		'sala',
		'complemento'
		);

	public static $rules = array(
		'autoridades_id'  =>           'required|min:1',
		'predios_id'      =>           'required|min:1',
		'sala'            => 'sometimes|required|min:1',
		'complemento'     => 'sometimes|required|min:1',
		);

	public function autoridade()
	{
		// Model, foreign, local
		return $this->hasOne('App\Autoridade', 'id', 'autoridades_id');
	}

	public function predio()
	{
		// Model, foreign, local
		return $this->hasOne('App\Predio', 'id', 'predios_id');
	}

	public function carga()
	{
		// Model, foreign, local
		return $this->hasMany('App\Carga', 'autoridades_predios_id', 'id');

	}

}
