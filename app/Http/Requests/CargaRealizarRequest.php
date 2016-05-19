<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CargaRealizarRequest extends Request {

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
			'autoridade_id'         =>  'required|min:1',
			'enderecos'             =>  'required|min:1',
			'obras'                 =>  'required|min:1',
			'destinatario'          =>  'required|min:1',
			'solicitante'           =>  'required|min:1',
			'tipos_solicitacoes_id' =>  'required|min:1',
		];
	}

}
