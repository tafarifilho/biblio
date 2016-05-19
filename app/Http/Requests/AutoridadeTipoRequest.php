<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class AutoridadeTipoRequest extends Request {

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
			'tipo'       => 'required|min:5',
			'tratamento' => 'required|min:3',
			'abreviado'  => 'required|min:3',
			'prazo'      => 'required|min:1|numeric'
		];
	}

}
