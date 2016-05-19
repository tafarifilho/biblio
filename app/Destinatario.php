<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Destinatario extends Model {

	use SoftDeletes;

	protected $table = 'destinatarios';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['destinatario'];

	public static $rules = array(
		'destinatario' => 'required|min:5'
		);

	public function carga()
	{
		// Model, foreign, local
		return $this->hasMany('App\Carga', 'destinatarios_id', 'id');
	}

}
