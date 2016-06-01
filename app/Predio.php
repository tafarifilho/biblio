<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Predio;
use App\Autoridade;
use App\AutoridadePredio;

class Predio extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'predios';

	protected $fillable = array(
		'predio', 
		'endereco', 
		'numero', 
		'complemento', 
		'cidade', 
		'estado', 
		'cep', 
		'tronco'
		);

	public static $rules = array(
		'predio'       => 'required|min:5',
		'endereco'     => 'required|min:5',
		'numero'       => 'required|min:1',
		'complemento'  => 'required|min:2',
		'cidade'       => 'required|min:2',
		'estado'       => 'required|min:2',
		'cep'          => 'required|size:9',
		'tronco'       => 'required|size:14',
		);

	public function autoridade()
	{
		return $this->belongsToMany('App\Autoridade', 'autoridades_predios', 'predios_id', 'autoridades_id')->wherePivot('deleted_at', null)->withTimestamps();
	}

	public function scopeApagados ($query)
	{
		$query->withTrashed();
	}

	public function scopeOrdem ($query)
	{
		$query->orderBy('predio', 'ASC');
	}

}
