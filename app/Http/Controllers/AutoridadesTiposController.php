<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\AutoridadeTipo;
use App\Http\Requests\AutoridadeTipoRequest;

use Illuminate\Http\Request;

class AutoridadesTiposController extends Controller {

	public function getListar()
	{
		$autoridadestipos = AutoridadeTipo::apagados()->orderBy('tipo', 'asc')->get();
		return view('autoridadetipo.listar', compact('autoridadestipos'));
	}

	public function getCadastrar()
	{
		return view('autoridadetipo.cadastrar');
	}

	public function postCadastrar(AutoridadeTipoRequest $request)
	{
		$autoridadetipo = AutoridadeTipo::create($request->all());
		return redirect('/autoridadetipo/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Tipo de Autoridade cadastrado com sucesso.');
	}

	public function getEditar($id)
	{
		$autoridadetipo = AutoridadeTipo::findOrFail($id);
		return view('autoridadetipo.editar', compact('autoridadetipo'));
	}

	public function postEditar($id, AutoridadeTipoRequest $request)
	{
		$autoridadetipo = AutoridadeTipo::findOrFail($id);
		$autoridadetipo->update($request->all());
		return redirect('/autoridadetipo/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Tipo de Autoridade atualizado com sucesso.');
	}

	public function getApagar($id)
	{
		$autoridadetipo = AutoridadeTipo::findOrFail($id);
		$autoridadetipo->delete();
		return redirect('/autoridadetipo/listar')
			->with('tipo_message', 'Perigo')
			->with('message', 'Tipo de Autoridade apagado com sucesso.');
	}

	public function getReativar($id)
	{
		$autoridadetipo = AutoridadeTipo::apagados()->findOrFail($id);
		$autoridadetipo->restore();
		return redirect('/autoridadetipo/listar')
			->with('tipo_message', 'Aviso')
			->with('message', 'Tipo de Autoridade reativado com sucesso.');
	}

}
