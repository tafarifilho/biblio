<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class UsuarioCadastrarRequest extends Request {

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
		'first_name'    =>       'required|min:2',
		'last_name'     =>       'required|min:2',
		'email'         => 'email|required|min:13|unique:users',
		'matricula'     =>       'required|min:7',
		'password'      =>       'required|min:1|confirmed',
		];
	}

}
