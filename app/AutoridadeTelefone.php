<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\AutoridadeTelefone;
use App\Autoridade;

class AutoridadeTelefone extends Model {

	//use SoftDeletes;

	protected $table = 'autoridades_telefones';

	protected $fillable = array(
		'autoridades_id', 
		'telefone',
		'tipo_telefone'
		);

	public static $rules = array(
		'autoridades_id'  => 'required|min:1',
		'telefone'        => 'required|min:9',
		);

	public function autoridade()
	{
		// Model, foreign, local
		return $this->belongsTo('App\Autoridade', 'id', 'autoridades_id');
	}

}
