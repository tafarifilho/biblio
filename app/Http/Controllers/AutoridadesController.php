<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\AutoridadeCadastrarRequest;
use App\Http\Requests\TelefoneAtualizarRequest;
use App\Http\Requests\EnderecoAtualizarRequest;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;

use App\Autoridade;
use App\AutoridadeTipo;
use App\AutoridadePredio;
use App\AutoridadeTelefone;
use App\Predio;
use Request;

class AutoridadesController extends Controller {

	public function getApi()
	{
		// XGH
		$autoridade = Request::get('nome');
		$autoridade = explode(' ', $autoridade);

		switch (count($autoridade)) {
			case 1;
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->get();
				break;
			case 2;
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->where('nome', 'LIKE', '%'.$autoridade[1].'%')->get();
				break;
			case 3;
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->where('nome', 'LIKE', '%'.$autoridade[1].'%')->where('nome', 'LIKE', '%'.$autoridade[2].'%')->get();
				break;
			case 4;
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->where('nome', 'LIKE', '%'.$autoridade[1].'%')->where('nome', 'LIKE', '%'.$autoridade[2].'%')->where('nome', 'LIKE', '%'.$autoridade[3].'%')->get();
				break;
			case 5;
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->where('nome', 'LIKE', '%'.$autoridade[1].'%')->where('nome', 'LIKE', '%'.$autoridade[2].'%')->where('nome', 'LIKE', '%'.$autoridade[3].'%')->where('nome', 'LIKE', '%'.$autoridade[4].'%')->get();
				break;
			default:
				$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade[0].'%')->get();
				break;
		}

		//$autoridades = Autoridade::where('nome', 'LIKE', '%'.$autoridade.'%')->get();

		$valores = [];

		$endereco = '';

		foreach ($autoridades as $autoridade) 
		{
			$enderecos = [];
			$cargas = [];

			foreach ($autoridade->predio()->get() as $predio)
			{
				$enderecos[] = array(
					'id'          => $predio->pivot->id,
					'predio'      => $predio->predio,
					'sala'        => $predio->pivot->sala,
					'complemento' => $predio->pivot->complemento
					);
			}

			foreach ($autoridade->carga()->abertas()->get() as $carga)
			{
				$cargas[] = array(
					'id'         => $carga->id,
					'data_carga' => $carga->data_carga->format('d\/m\/Y \(H:i \h\s\)'),
					'nome'       => $carga->nome,
					'titulo'     => $carga->titulo,
					);
			}

			$valores[] = array(
				'id'       => $autoridade->id,
				'nome'     => $autoridade->nome,
				'tipo'     => $autoridade->tipo()->first()->tipo,
				'endereco' => $enderecos,
				'cargas'   => $cargas
			);

		}

		return $valores;
	}

	public function getCadastrar()
	{
		$tipos_autoridades = AutoridadeTipo::all();
		return view('autoridade.cadastrar', compact('tipos_autoridades'));
	}

	public function postCadastrar(AutoridadeCadastrarRequest $request)
	{

		if ($request->input('autoridade_id'))
		{
			return redirect('/autoridade/cadastrar')
				->with('tipo_message', 'Perigo')
				->with('message', 'Não é possível cadastrar autoridade já existente.');
		}

		$autoridade = new Autoridade;

		$autoridade->nome = trim($request->input('autoridade'));

		// Tipo Autoridade
		$autoridadeTipo = AutoridadeTipo::findOrFail($request->input('tipo_autoridade_id'));
		$autoridade->tipo()->associate($autoridadeTipo);

		// Gênero
		$autoridade->genero = $request->input('genero');

		// Email e Observação
		if ($request->input('email'))
			$autoridade->email = trim($request->input('email'));
		if ($request->input('observacao'))
			$autoridade->observacao = trim($request->input('observacao'));

		// Salvar Nova Autoridade
		$autoridade->save();

		// Imagem
		if ($request->hasFile('foto'))
		{
			// Coloca a imagem em seu local correto
			$foto = $request->file('foto');
			$novoNome = $autoridade->id . '.' . $foto->guessExtension();
			$fotoSucesso = $foto->move(base_path().'/public/images/autoridades/', $novoNome);

			// Anota a informação para ser cadastrada
			if ($fotoSucesso)
			{
				$autoridade->imagem = true;
				$autoridade->save();

				// Cria miniatura
				$novoNomeMini = $novoNome = $autoridade->id . '_mini.png';
				$miniatura = Image::make($fotoSucesso);

				$miniatura->resize(140, null, function($constraint){
					$constraint->aspectRatio();
				})
					->encode('png')->save(base_path().'/public/images/autoridades/'.$novoNomeMini);
			}
		}

		// Prédio
		if ($request->input('predio_id'))
		{
			$outrosValores = [];
			if($request->input('sala'))
				$outrosValores = array_add($outrosValores, 'sala', $request->input('sala'));
			if($request->input('complemento'))
				$outrosValores = array_add($outrosValores, 'complemento', $request->input('complemento'));
			$autoridade->predio()->attach($request->input('predio_id'), $outrosValores);
		}


		// Telefones
		if ( count($request->input('telefones')) > 0 && !empty($request->input('telefones')[0]) )
		{
			$telefone = $request->input('telefones');
			$tipo_telefone = $request->input('tipos_telefones');
			for ($i = 0; count($telefone) > $i; $i++)
			{
				$tel = new AutoridadeTelefone;
				$tel->telefone = $telefone[$i];
				if ($tipo_telefone[$i])
					$tel->tipo_telefone = $tipo_telefone[$i];
				$autoridade->telefone()->save($tel);
			}
		}

		return redirect('/autoridade/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Autoridade cadastrada com sucesso.');

	}

	public function getListar()
	{
		$autoridades = Autoridade::apagadas()->ordem()->get();
		return view('autoridade.listar', compact('autoridades'));
	}

	public function getExibir($id)
	{
		$autoridade = Autoridade::apagadas()->findOrFail($id);
		return view('autoridade.exibir', compact('autoridade'));
	}

	public function getEditar($id)
	{
		$autoridade = Autoridade::findOrFail($id);
		$tipos_autoridades = AutoridadeTipo::lists('tipo','id');
		return view('autoridade.editar', compact('autoridade', 'tipos_autoridades'));
	}

	public function postEditar(AutoridadeCadastrarRequest $request)
	{
		$autoridade = Autoridade::findOrFail($request->autoridade_id);

		$autoridade->nome = trim($request->input('autoridade'));

		// Tipo Autoridade
		$autoridadeTipo = AutoridadeTipo::findOrFail($request->input('tipo_autoridade_id'));
		$autoridade->tipo()->associate($autoridadeTipo);

		// Gênero
		$autoridade->genero = $request->input('genero');

		// Email e Observação
		if ($request->input('email'))
			$autoridade->email = trim($request->input('email'));
		if ($request->input('observacao'))
			$autoridade->observacao = trim($request->input('observacao'));

		// Salvar Nova Autoridade
		$autoridade->save();

		// Imagem
		if ($request->hasFile('foto'))
		{
			// Coloca a imagem em seu local correto
			$foto = $request->file('foto');
			$novoNome = $autoridade->id . '.' . $foto->guessExtension();
			$fotoSucesso = $foto->move(base_path().'/public/images/autoridades/', $novoNome);

			// Anota a informação para ser cadastrada
			if ($fotoSucesso)
			{
				$autoridade->imagem = true;
				$autoridade->save();

				// Cria miniatura
				$novoNomeMini = $novoNome = $autoridade->id . '_mini.png';
				$miniatura = Image::make($fotoSucesso);

				$miniatura->resize(140, null, function($constraint){
					$constraint->aspectRatio();
				})
					->encode('png')->save(base_path().'/public/images/autoridades/'.$novoNomeMini);
			}
		}

		return redirect('/autoridade/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Autoridade cadastrada com sucesso.');
	}

	public function getApagar($id)
	{
		$autoridade = Autoridade::findOrFail($id);
		$autoridade->delete();
		return redirect('/autoridade/listar')
			->with('tipo_message', 'Perigo')
			->with('message', 'Autoridade apagada com sucesso.');
	}

	public function getReativar($id)
	{
		$autoridade = Autoridade::apagadas()->findOrFail($id);
		$autoridade->restore();
		return redirect('/autoridade/listar')
			->with('tipo_message', 'Aviso')
			->with('message', 'Autoridade reativada com sucesso.');
	}

	public function getImagemFull($id)
	{
		$url = '/images/autoridades/' . $id . '.png';
		return redirect($url);
	}

	public function getImagemMini($id)
	{
		$url = '/images/autoridades/' . $id . '_mini.png';
		return redirect($url);
	}

	public function getTelefone($id)
	{
		$autoridade = Autoridade::findOrFail($id);
		return view('autoridade.telefone', compact('autoridade'));
	}

	public function postTelefone(TelefoneAtualizarRequest $request)
	{
		$autoridade = Autoridade::findOrFail($request->input('autoridade_id'));

		if ($request->input('telefones'))
			$autoridade->sincronizarTelefone($request->input('telefones'), $request->input('tipos_telefones'));
		else
			$delete = $autoridade->telefone()->delete();

		return redirect('/autoridade/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Telefones atualizados com sucesso.');
	}

	public function getPredio($id)
	{
		$autoridade = Autoridade::findOrFail($id);
		return view('autoridade.predio', compact('autoridade'));
	}

	public function postPredio(EnderecoAtualizarRequest $request)
	{

		$autoridade = Autoridade::findOrFail($request->input('autoridade_id'));

		if ($request->input('predio_id'))
			$autoridade->sincronizarPredio($request->input('predio_id'), $request->input('sala'), $request->input('complemento'));
		else
			//$delete = $autoridade->predio()->delete();
			dd('iria apagar');
		return redirect('/autoridade/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Prédios atualizados com sucesso.');

	}

	public function getAdministrarTelefones()
	{
		$predios = Predio::ordem()->get();
		return view('autoridade.administrartelefones', compact('predios'));
	}

}









