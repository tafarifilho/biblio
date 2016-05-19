<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use Carbon\Carbon;

use App\Destinatario;
use App\Obra;

class ObrasController extends Controller {

	public function getRealizar()
	{

		$destinatarios = Destinatario::all();

		return view('carga.realizar', compact('destinatarios'));

	}

	public function getApi()
	{

		// Consulta pelo Tombo
		if (Request::get('tombo'))
		{
			$keyword = Request::get('tombo');
/*
			$obras = Obra::where('v10._', 'like', "%$keyword%")
				->orWhere('v12._', 'like', "%$keyword%")
				->orWhere('v20._', 'like', "%$keyword%")
				->where(function($query)
				{
					$query->where(    'v8._', '=', 'Livro')
						->orWhere('v8._', '=', 'Livro ')
						->orWhere('v8._', '=', 'livro')
						->orWhere('v8._', '=', 'Tese')
						->orWhere('v8._', '=', 'Folheto')
						->orWhere('v8._', '=', 'Livro - Obra rara')
						->orWhere('v8._', '=', 'Livro - obra rara')
						->orWhere('v8._', '=', ' Livro - Obra rara')
						->orWhere('v8._', '=', 'Livro - Obra Rara')
				})->take(5)->get();
*/
			$obras = Obra::where('v10._', 'like', "%$keyword%")
			->orWhere('v12._', 'like', "%$keyword%")
			->orWhere('v20._', 'like', "%$keyword%")
			->take(5)
			->get();
		}
		// Consulta pela CS/Estante/Prateleira/Número
		elseif (Request::get('fixa'))
		{
			//150-151-152-153
			$keywords = explode('/', Request::get('fixa'));

			if(count($keywords) == 4)
			{
				$obras = Obra::where('v8._', '=', 'Livro')
				->where('v150._', 'like', '%'.$keywords[0].'%')
				->Where('v151._', 'like', '%'.$keywords[1].'%')
				->Where('v152._', 'like', '%'.$keywords[2].'%')
				->Where('v153._', '=', $keywords[3])
				->orderBy('v150._', 'desc')
				->orderBy('v151._', 'desc')
				->orderBy('v152._', 'desc')
				->orderBy('v153._', 'desc')
				->take(10)
				->get();
			}
			elseif (count($keywords) == 3)
			{
				$obras = Obra::where('v8._', '=', 'Livro')
				->Where('v151._', 'like', '%'.$keywords[0].'%')
				->Where('v152._', 'like', '%'.$keywords[1].'%')
				->Where('v153._', '=', $keywords[2])
				->orderBy('v151._', 'desc')
				->orderBy('v152._', 'desc')
				->orderBy('v153._', 'desc')
				->take(10)
				->get();				
			}
			else // Provavelmente formato incorreto
			{
				$obras = [];
			}

		}

		$valores = [];
		$tombo = "";

		foreach ($obras as $obra) {
			$id            = '';
			$titulo        = '';
			$autor         = '';
			$classificacao = '';
			$notacao       = '';
			$volume        = '';
			$edicao        = '';
			$ano           = '';
			$cs            = '';
			$estante       = '';
			$prateleira    = '';
			$numero        = '';
			$digito        = '';

			// ID
			if ($obra->id)
				$id = $obra->id;

			// Tombo
			if ($obra->v10)
			{
				if(count($obra->v10) > 1)
				{
					$tombo = $obra->v10[0]['_'];
				}
				else
					$tombo = $obra->v10['_'];
			}
			if ($obra->v12)
			{
				if(count($obra->v12) > 1)
				{
					$tombo = $obra->v12[0]['_'];
				}
				else
					$tombo = $obra->v12['_'];
			}

			// Título
			$titulo = preg_replace("/[ˆ<>]/i", "", $obra['v40']['_']);

			// Autor
			if ($obra->v25)
			{
				if(count($obra->v25) > 1)
					$autor = $obra->v25[0]['_'];
				else
					$autor = $obra->v25['_'];
			}
			// Classificação
			if ($obra->v1)
				$classificacao = $obra->v1['_'];

			// Notação
			if ($obra->v2)
				$notacao = $obra->v2['_'];

			// Volume
			if ($obra->v139 && $obra->v138 && $obra->v142) // Volume / Tomo / Numero
				$volume = $obra->v139['_'] . '/' . $obra->v138['_'] . '/' . $obra->v142['_'];
			elseif($obra->v139 && $obra->v138)// Volume / Tomo
				$volume = $obra->v139['_'] . '/' . $obra->v138['_']; 
			elseif($obra->v139 && $obra->v142) // Volume / Numero
				$volume = $obra->v139['_'] . '/' . $obra->v142['_'];
			elseif($obra->v138 && $obra->v142) // Tomo / Numero
				$volume = $obra->v138['_'] . '/' . $obra->v142['_'];
			elseif($obra->v139) // Volume
				$volume = $obra->v139['_']; 
			elseif($obra->v138) // Tomo
				$volume = $obra->v138['_']; 
			elseif($obra->v142) // Numero
				$volume = $obra->v142['_']; 

			// Edição
			if ($obra->v50)
				$edicao = $obra->v50['_'];
			// Ano
			if ($obra->v70)
				$ano = $obra->v70['_'];

			// Localização
			$localizacao = '';

			// Conjunto Suplementar
			if ($obra->v150)
			{
				$cs = $obra->v150['_'];
				$localizacao = 'CS' . $cs . '/';
			}

			// Estante
			if ($obra->v151)
			{
				$estante = $obra->v151['_'];
				$localizacao = $localizacao . 'E' . $estante;
			}

			// Prateleira
			if ($obra->v152)
			{
				$prateleira = $obra->v152['_'];
				$localizacao = $localizacao . '/P' . $prateleira; 
			}

			// Número e Dígito
			if ($obra->v153)
			{
				$parte = explode('-', $obra->v153['_']);
				$numero = $parte[0];
				$localizacao = $localizacao . '/N' . $numero;
				if (!empty($parte[1]))
				{
					$digito = $parte[1]; 
					$localizacao = $localizacao . '-' . $digito;
				}

			}

			// Array de Retorno
			$valores[] = array(
				'id'            => trim($id),
				'tombo'         => trim($tombo), 
				'titulo'        => trim($titulo),
				'autor'         => trim($autor),
				'classificacao' => trim($classificacao),
				'notacao'       => trim($notacao),
				'volume'        => trim($volume),
				'edicao'        => trim($edicao),
				'ano'           => trim($ano),
				'cs'            => trim($cs),
				'estante'       => trim($estante),
				'prateleira'    => trim($prateleira),
				'numero'        => trim($numero),
				'digito'        => trim($digito),
				'localizacao'   => trim($localizacao)
			);

			unset($id);
			unset($titulo);
			unset($autor);
			unset($classificacao);
			unset($notacao);
			unset($volume);
			unset($edicao);
			unset($ano);
			unset($cs);
			unset($estante);
			unset($prateleira);
			unset($numero);
			unset($digito);
			unset($localizacao);
		}

		return $valores;

	}

}
