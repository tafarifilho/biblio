<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CargaRenovarRequest extends Request {

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
			'contato'      => 'required|min:3',
			'observacao'   => 'required|min:5',
			'prazo'        => 'required_without:excepcional|numeric|between:5,15',
			'excepcional'  => 'required_without:prazo|numeric|between:5,120'
		];
	}

}
