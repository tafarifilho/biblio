<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class PredioRequest extends Request {

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
			'predio'      => 'required|min:5',
			'endereco'    => 'required|min:5',
			'numero'      => 'required|min:1',
			'complemento' =>          'min:3',
			'cidade'      => 'required|min:3',
			'estado'      => 'required|string|size:2',
			'cep'         => 'required|string|size:9',
			'tronco'      => 'required|string|size:14'
		];
	}

}
