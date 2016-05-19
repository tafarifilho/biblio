<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

// Requests
use App\Http\Requests;
use App\Http\Requests\CargaRealizarRequest;
use App\Http\Requests\CargaRenovarRequest;
use App\Http\Requests\CargaComentarRequest;

// Facades
use Carbon\Carbon;
use Cartalyst\Sentry\Facades\Laravel\Sentry;

// Models
use App\Autoridade;
use App\AutoridadeTipo;
use App\Carga;
use App\ControleCarga;
use App\Destinatario;
use App\Obra;
use App\TipoSolicitacao;

class CargasController extends Controller {

	public $usuarioAtual;

	public function __construct()
	{
		$this->usuarioAtual = Sentry::getUser();
	}

	public function getRealizar()
	{

		$destinatarios = Destinatario::all();
		$tiposSolicitacoes = TipoSolicitacao::all();

		return view('carga.realizar', compact('destinatarios', 'tiposSolicitacoes'));

	}

	public function postRealizar(CargaRealizarRequest $request)
	{

		// O número da Carga deve ser único
		// Se o Looping demorar, o STAMP da carga pode variar em 1
		$stampDaCarga = Carbon::now()->timestamp;

		foreach ($request->input('obras') as $obra) {
			// Resgatar as informações da obra
			// Verificar se é ID ou por extenso.

			if (strlen($obra) > 8) // Tamanho provável máximo de um ID (mfn)
			{
				$dados = array();
				parse_str($obra, $dados);

				if ($dados['tombo'])
					$tombo = $dados['tombo'];
				if ($dados['titulo'])
					$titulo = $dados['titulo'];
				if ($dados['autor'])
					$nome = $dados['autor'];
				if ($dados['classificacao'])
					$classificacao = $dados['classificacao'];
				if ($dados['notacao'])
					$notacao = $dados['notacao'];
				if ($dados['volume'])
					$volume = $dados['volume'];
				if ($dados['edicao'])
					$edicao = $dados['edicao'];
				if ($dados['ano'])
					$ano = $dados['ano'];
				if ($dados['cs'])
					$cs = $dados['cs'];
				if ($dados['estante'])
					$estante = $dados['estante'];
				if ($dados['prateleira'])
					$prateleira = $dados['prateleira'];
				if ($dados['numero'])
					$numero = $dados['numero'];
				if ($dados['digito'])
					$digito = $dados['digito'];
			}

			// Está recebendo o MFN
			else
			{

				$livro = Obra::find($obra)->toArray();

				$mfn = $livro['_id'];

				if (array_key_exists('v12', $livro))
					$tombo = $livro['v12']['_'];
				elseif(array_key_exists('v10', $livro))
					$tombo = $livro['v10']['_'];

				if (array_key_exists('v40', $livro))
					$titulo = trim(preg_replace("/[ˆ<>]/i", "", $livro['v40']['_']));

				if (array_key_exists('v25', $livro))
				{
					if(count($livro['v25']) > 1)
						$nome = trim($livro['v25'][0]['_']);
					else
						$nome = trim($livro['v25']['_']);
				}

				if (array_key_exists('v1', $livro))
					$classificacao = $livro['v1']['_'];

				if (array_key_exists('v2', $livro))
					$notacao = $livro['v2']['_'];

				if (array_key_exists('v139', $livro))
				{
					if (array_key_exists('v138', $livro)) // Se também tem Tomo
						$volume = $livro['v139']['_'] . ' ' . $livro['v138']['_'];
					else
						$volume = $livro['v139']['_'];
				}
				else
				{
					if (array_key_exists('v138', $livro)) // Tomo
						$volume = $livro['v138']['_'];
					else
					{
						if (array_key_exists('v142', $livro)) // Parte
							$volume = $livro['v142']['_'];
					}
				}

				if (array_key_exists('v70', $livro))
					$ano = $livro['v70']['_'];
				if (array_key_exists('v50', $livro))
					$edicao = $livro['v50']['_'];

				if (array_key_exists('v150', $livro))
					$cs = $livro['v150']['_'];
				if (array_key_exists('v151', $livro))
					$estante = $livro['v151']['_'];
				if (array_key_exists('v152', $livro))
					$prateleira = $livro['v152']['_'];
				if (array_key_exists('v153', $livro))
				{
					$parte = explode('-', $livro['v153']['_']);
					$numero = $parte[0];
					if (!empty($parte[1]))
						$digito = $parte[1]; 
				}

			}

			$autoridade = Autoridade::find($request->input('autoridade_id'));

			// Iniciar definicação de valores
			$carga = new Carga;
			$carga->autoridades_id = $autoridade->id;
			$carga->carga = $stampDaCarga;

			if(isset($mfn))
				$carga->mfn = $mfn;
			if(isset($cs))
				$carga->cs = $cs;
			if(isset($estante))
				$carga->estante = $estante;
			if(isset($prateleira))
				$carga->prateleira = $prateleira;
			if(isset($numero))
				$carga->numero = $numero;
			if(isset($digito))
				$carga->digito = $digito;
			if(isset($tombo))
				$carga->tombo = $tombo;
			if(isset($classificacao))
				$carga->classificacao = $classificacao;
			if(isset($notacao))
				$carga->notacao = $notacao;
			if(isset($volume))
				$carga->volume = $volume;
			if(isset($nome))
				$carga->nome = $nome;
			if(isset($titulo))
				$carga->titulo = $titulo;
			if(isset($edicao))
				$carga->edicao = $edicao;
			if(isset($ano))
				$carga->ano = $ano;

			$carga->data_carga                = Carbon::now();

			$carga->funcionarios_carga_id     = $this->usuarioAtual->id;
			$carga->data_cobranca             = Carbon::now()->addDays($autoridade->tipo->prazo);

			if ($request->input('destinatario_enderecos'))
				$carga->autoridades_predios_id  = $request->input('destinatario_enderecos');
			else
				$carga->autoridades_predios_id  = $request->input('enderecos');

			if ($request->input('destinatario'))
				$carga->destinatarios_id         = $request->input('destinatario');
			if ($request->input('solicitante'))
				$carga->solicitante             = $request->input('solicitante');
			if ($request->input('email_solicitante'))
				$carga->email_solicitante       = $request->input('email_solicitante');
			if ($request->input('tipos_solicitacoes_id'))
				$carga->tipos_solicitacoes_id   = $request->input('tipos_solicitacoes_id');
			if ($request->input('retirante'))
				$carga->retirante               = $request->input('retirante');
			if ($request->input('observacao'))
				$carga->observacao              = $request->input('observacao');

			$carga->save();

			// Cadastrar o Controle Inicial da Carga
			$controleCarga = new ControleCarga;
			$controleCarga->funcionarios_id = $this->usuarioAtual->id;
			$controleCarga->controle = 'Data Inicial da Cobrança (' . $carga->data_cobranca->format('d\/m\/Y H:i \h\s') . ')';
			$carga->controles()->save($controleCarga);

			// Unset Variables;
			unset($dados);
			unset($obras);
			unset($livro);
			unset($mfn);
			unset($cs);
			unset($estante);
			unset($prateleira);
			unset($numero);
			unset($digito);
			unset($tombo);
			unset($classificacao);
			unset($notacao);
			unset($volume);
			unset($nome);
			unset($titulo);
			unset($edicao);
			unset($ano);

		}

		return redirect('/carga/listar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Carga realizada com sucesso.');

	}

	public function getBaixar()
	{
		$cargas = Carga::velhas()->abertas()->get();
		return view('carga.baixar', compact('cargas'));
	}

	public function getRealizarBaixa($id)
	{
		$carga = Carga::find($id);
		$carga->data_baixa = Carbon::now();
		$carga->funcionarios_baixa_id = $this->usuarioAtual->id;
		$carga->save();
		return redirect('/carga/baixar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Baixa realizada com sucesso.');
	}

	public function getListar()
	{
		$cargas = Carga::apagadas()->velhas()->paginate(10);
		return view('carga.listar', compact('cargas'));
	}

	public function postListar()
	{
		// Desmembrar pesquisas de acordo com os campos enviados pelo imput
	}

	public function getListarAbertas()
	{
		$cargas = Carga::abertas()->velhas();
		return view('carga.listarabertas', compact('cargas'));
	}

	public function getExibir($carga)
	{
		$cargas = Carga::apagadas()->where('carga', '=', $carga)->get();
		return view('carga.exibir', compact('cargas'));
	}

	public function getEditar($id)
	{
		return view('carga.editar')
			->with('carga', Carga::findOrFail($id));
	}

	public function postEditar()
	{
		return true;
	}

	public function getCobrar()
	{
		$cargas = Carga::velhas()->abertas()->vencidas()->get();
		$autoridadesTipos = AutoridadeTipo::orderBy('tipo', 'ASC')->get();
		return view('carga.cobrar', compact('cargas', 'autoridadesTipos'));
	}

	public function postCobrar(CargaRenovarRequest $request)
	{
		if ( ! empty($request->input('prazo')) )
			$prazo = $request->input('prazo');
		else
			$prazo = $request->input('excepcional');

		foreach ($request->input('id') as $id)
		{
			$carga = Carga::find($id);
			$carga->data_cobranca = Carbon::now()->addDays($prazo);
			$carga->save();

			// Cadastrar o Controle 
			$controle = new ControleCarga;
			$controle->funcionarios_id = $this->usuarioAtual->id;
			$controle->controle = 'Cobrança Renovada para (' . $carga->data_cobranca->format('d\/m\/Y H:i \h\s') . '). Contato (' . $request->input('contato') .'). Obs: (' . $request->input('observacao') . ')';
			$carga->controles()->save($controle);
		}
		return redirect()->route('carga.cobrar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Carga(s) renovadas com sucesso.');
	}

	public function getRenovar()
	{
		$cargas = Carga::velhas()->abertas()->get();
		$autoridadesTipos = AutoridadeTipo::orderBy('tipo', 'ASC')->get();
		return view('carga.renovar', compact('cargas', 'autoridadesTipos'));
	}

	public function postRenovar(CargaRenovarRequest $request)
	{
		if ( ! empty($request->input('prazo')) )
			$prazo = $request->input('prazo');
		else
			$prazo = $request->input('excepcional');

		foreach ($request->input('id') as $id)
		{
			$carga = Carga::find($id);
			$carga->data_cobranca = Carbon::now()->addDays($prazo);
			$carga->save();

			// Cadastrar o Controle 
			$controle = new ControleCarga;
			$controle->funcionarios_id = $this->usuarioAtual->id;
			$controle->controle = 'Cobrança Renovada para (' . $carga->data_cobranca->format('d\/m\/Y H:i \h\s') . '). Contato (' . $request->input('contato') .'). Obs: (' . $request->input('observacao') . ')';
			$carga->controles()->save($controle);
		}
		return redirect()->route('carga.renovar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Carga(s) renovadas com sucesso.');
	}

	public function getComentar()
	{
		$cargas = Carga::velhas()->abertas()->get();
		$autoridadesTipos = AutoridadeTipo::orderBy('tipo', 'ASC')->get();
		return view('carga.comentar', compact('cargas', 'autoridadesTipos'));
	}

	public function postComentar(CargaComentarRequest $request)
	{
		foreach ($request->input('id') as $id)
		{
			// Pesquisa Carga
			$carga = Carga::find($id);

			// Cadastrar o Controle
			$controle = new ControleCarga;
			$controle->funcionarios_id = $this->usuarioAtual->id;
			$controle->controle = 'Comentário - Contato (' . $request->input('contato') .'). Obs: (' . $request->input('observacao') . ')';
			$carga->controles()->save($controle);
		}
		return redirect()->route('carga.comentar')
			->with('tipo_message', 'Sucesso')
			->with('message', 'Comentários realizados com sucesso.');
	}

	public function getApagar($id)
	{
		$carga = Carga::find($id);
		$carga->delete();
		return redirect('/carga/listar')
			->with('tipo_message', 'Perigo')
			->with('message', 'Carga apagada com sucesso.');
	}

	public function getReativar($id)
	{
		$carga = Carga::apagadas()->find($id);
		$carga->restore();
		return redirect('/carga/listar')
			->with('tipo_message', 'Aviso')
			->with('message', 'Carga reativada com sucesso.');
	}

	public function getImprimir($carga)
	{
		$carga = Carga::where('carga',  $carga)->get();
		return view('imprimir.recibo')->with('cargas', $carga);
	}

}
