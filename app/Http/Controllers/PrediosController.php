<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Http\Requests\PredioRequest;

use App\Predio;

class PrediosController extends Controller {

	public function getApi()
	{
		$predio = Request::get('predio');

		$predios = Predio::where('predio', 'LIKE', '%'.$predio.'%')
											->orWhere('endereco', 'LIKE', '%'.$predio.'%')
											->orWhere('cidade', 'LIKE', '%'.$predio.'%')
											->get();

		$valores = [];

		foreach ($predios as $predio) 
		{

			if ($predio->endereco)
			{
				$endereco = '(';
				$endereco = ($predio->endereco)    ? $endereco          . $predio->endereco    : $endereco;
				$endereco = ($predio->numero)      ? $endereco . ' nº ' . $predio->numero      : $endereco;
				$endereco = ($predio->complemento) ? $endereco . ', '   . $predio->complemento : $endereco;
				$endereco = ($predio->cidade)      ? $endereco . ', '   . $predio->cidade      : $endereco;
				$endereco = ($predio->estado)      ? $endereco . '/'    . $predio->estado      : $endereco;
				$endereco = $endereco . ')';

				$valores[] = array(
					'id'       => $predio->id,
					'predio'   => $predio->predio,
					'endereco' => $endereco
				);

			}
		}

		return $valores;
	}

	public function getListar()
	{
		$predios = Predio::apagados()->orderBy('predio', 'asc')->get();
		return view('predio.listar', compact('predios'));
	}

	public function getCadastrar()
	{
		return view('predio.cadastrar');
	}

	public function postCadastrar(PredioRequest $request)
	{
		$predio = Predio::create($request->all());
		return redirect('/predio/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Prédio cadastrado com sucesso.');
	}

	public function getEditar($id)
	{
		$predio = Predio::findOrFail($id);
		return view('predio.editar', compact('predio'));
	}

	public function postEditar($id, PredioRequest $request)
	{
		$predio = Predio::findOrFail($id);
		$predio->update($request->all());
		return redirect('/predio/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Prédio atualizado com sucesso.');
	}

	public function getApagar($id)
	{
		$predio = Predio::findOrFail($id);
		$predio->delete();
		return redirect('/predio/listar')
			->with('tipo_message', 'Perigo')
			->with('message', 'Prédio apagado com sucesso.');
	}

	public function getReativar($id)
	{
		$predio = Predio::apagados()->findOrFail($id);
		$predio->restore();
		return redirect('/predio/listar')
			->with('tipo_message', 'Aviso')
			->with('message', 'Prédio reativado com sucesso.');
	}

}