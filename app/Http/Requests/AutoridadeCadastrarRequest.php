<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AutoridadeCadastrarRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
		'autoridade'         => 'required|min:1',
		'genero'             => 'required|min:1',
		'email'              =>    'email|min:1',
		'tipo_autoridade_id' => 'required|min:1'
		];
	}

}
