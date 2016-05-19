<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// Models
use App\Autoridade;
use App\Predio;
use App\AutoridadePredio;

//Facades
use Carbon\Carbon;

class Carga extends Model {

	use SoftDeletes;

	protected $table = 'cargas';

	protected $dates = ['data_carga', 'data_baixa', 'data_cobranca'];

	protected $fillable = array(
		'autoridades_id', 
		'carga', 
		'cs', 
		'estante', 
		'prateleira', 
		'numero', 
		'digito', 
		'tombo',
		'classificao',
		'notacao',
		'volume',
		'nome', 
		'titulo',
		'edicao',
		'ano',
		'data_carga',
		'funcionarios_carga_id',
		'data_baixa',
		'funcionarios_baixa_id',
		'data_cobranca',
		'autoridades_predios_id',
		'destinatarios_id',
		'solicitante',
		'email_solicitante',
		'tipos_solicitacoes_id',
		'retirante',
		'observacao'
		);


	public static $rules = array(
		
		);

	// Atributos 
  // Formato: set NOME_CAMPO Attribute
	// Finalidade - Definir previamente como o campo deve ser inserido/resgatado
	public function setDataCobrancaAttribute($data)
	{
		$this->attributes['data_cobranca'] = Carbon::parse($data);
	}
	public function setDataCargaAttribute($data)
	{
		$this->attributes['data_carga'] = Carbon::parse($data);
	}
	public function setDataBaixaAttribute($data)
	{
		// Carbon::createFromFormat('Y-m-d', $data);
		$this->attributes['data_baixa'] = Carbon::parse($data);
	}

	// Scopos (Scorpe)
	// Formato - scope NOME_DE_INTERESSE
	// Finalidade - Simplificar consultas reiteradas
	// Exemplo - Model::blablabla()->cobranca()->get();
	public function scopeVencidas ($query)
	{
		$query->where('data_cobranca', '<=', Carbon::now());
	}

	public function scopeAbertas ($query)
	{
		$query->whereNull('data_baixa');
	}

	public function scopeVelhas ($query)
	{
		$query->orderBy('id', 'DESC');
	}

	public function scopeNovas ($query)
	{
		$query->orderBy('id', 'ASC');
	}

	public function scopeApagadas ($query)
	{
		$query->withTrashed();
	}

	public function autoridade()
	{
		// Model, foreign, local
		return $this->belongsTo('App\Autoridade', 'autoridades_id', 'id');
	}

	public function funcionariocarga()
	{
		// Model, foreign, local
		return $this->belongsTo('App\User', 'funcionarios_carga_id', 'id');
	}

	public function funcionariobaixa()
	{
		// Model, foreign, local
		return $this->belongsTo('App\User', 'funcionarios_baixa_id', 'id');
	}

	public function tiposolicitacao()
	{
		// Model, foreign, local
		return $this->belongsTo('App\TipoSolicitacao', 'tipos_solicitacoes_id', 'id')->withTrashed();
	}

	public function destinatario()
	{
		// Model, foreign, local
		return $this->belongsTo('App\Destinatario', 'destinatarios_id', 'id');
	}

	public function controles()
	{
		return $this->hasMany('App\ControleCarga', 'cargas_id', 'id');
	}

	public function destinatarioFisico()
	{
		// Model, local, parent
		return $this->belongsTo('App\AutoridadePredio', 'autoridades_predios_id', 'id');
	}

	public function obraEstruturada()
	{
		$obra = '';

		if($this->nome)
			$obra = '<strong>' . $this->nome . '</strong>. ';

		$obra = $obra . $this->titulo . '. ';

		if($this->volume)
			$obra = $obra . '<strong>' . $this->volume . '</strong>. ';

		if($this->edicao)
			$obra = $obra . $this->edicao . '. ';

		if($this->ano)
			$obra = $obra . $this->ano . '. ';

		if($this->tombo && $this->tombo != 'NULL' && $this->tombo != 'ST')
			$obra = $obra . '<strong>(Tombo: ' . $this->tombo . ')</strong>';
		else
		{
			if ($this->estante)
			{
				$obra = $obra . '<strong>(';
				if($this->cs)
					$obra = $obra . 'CS' . $this->cs . '/';
				if($this->estante)
					$obra = $obra . 'E' . $this->estante;
				if($this->prateleira)
					$obra = $obra . '/P' . $this->prateleira;
				if($this->numero)
					$obra = $obra . '/N' . $this->numero;
				if($this->digito)
					$obra = $obra . '-' . $this->digito;
				$obra = $obra . ')</strong>';
			}
		}

		return $obra;
	}
}


