<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Http\Requests\ConsultaRequest;

use App\Obra;

class ConsultaController extends Controller {

	public function getConsulta()
	{
		return view('consulta.formulario');
	}

	public function postResultado(ConsultaRequest $request)
	{
		$query = $request->input('consulta');

		$regex = '/-?"[\pL\s]+"|-?\pL+/u';
		preg_match_all($regex, $query, $tokens, PREG_SET_ORDER);

		$fields = '';

		foreach ($tokens as & $token)
		{
				$token = array_shift($token);
				$modifier = null;
				if ($token[0] === '-')
				{
					$modifier = $token[0];
					$token = '"' . substr($token, 1) . '"';
				}
				$token = $modifier.$token;
				$fields = $fields . ' ' . $token;
		}

		$obras = Obra::PesquisaLivro($fields)->get();

		return view('consulta.resultado', compact('obras'));
	}

}
