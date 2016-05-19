<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Autoridade;
use App\AutoridadeTipo;
use App\AutoridadePredio;
use App\AutoridadeTelefone;
use App\Predio;

use Carbon\Carbon;

use App\Support\Arrays;

class Autoridade extends Model {

	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $table = 'autoridades';

	protected $fillable = array(
		'nome', 
		'autoridades_tipos_id', 
		'email', 
		'observacao'
		);

	public static $rules = array(
		'nome'                  =>           'required|min:5',
		'autoridades_tipos_id'  =>           'required|min:1',
		'email'                 =>           'required|email',
		'observacao'            => 'sometimes|required|min:2'
		);

	public function scopeVelhas ($query)
	{
		$query->orderBy('id', 'DESC');
	}

	public function scopeNovas ($query)
	{
		$query->orderBy('id', 'ASC');
	}

	public function scopeOrdem ($query)
	{
		$query->orderBy('nome', 'ASC');
	}

	public function scopeApagadas ($query)
	{
		$query->withTrashed();
	}

	public function tipo()
	{
		return $this->belongsTo('App\AutoridadeTipo', 'autoridades_tipos_id', 'id');
	}

	public function predio()
	{
		return $this->belongsToMany('App\Predio', 'autoridades_predios', 'autoridades_id', 'predios_id')->withPivot('id', 'sala', 'complemento')->wherePivot('deleted_at', null)->withTimestamps();
	}

	public function autoridadepredio()
	{
		return $this->hasMany('App\AutoridadePredio', 'autoridades_id', 'id');
	}

	//public function syncOptions(array $options, $column = 'option')
	public function sincronizarPredio(array $predios, array $salas, array $complementos)
	{

		$input_predios      = $predios;
		$input_salas        = array_filter($salas);
		$input_complementos = array_filter($complementos);

		$db_predios      = $this->predio->lists('id', 'pivot.id');
		$db_salas        = $this->predio->lists('pivot.sala', 'pivot.id');
		$db_complementos = $this->predio->lists('pivot.complemento', 'pivot.id');

		// Apagar predios que não vieram no input
		if ($deleted = array_keys(array_diff_key($db_predios, $input_predios)))
		{
			$this->autoridadepredio()->whereIn('id', $deleted)->delete();
		}

		// Não será possível atualizar prédios já existes, para evitar o rompimento da continuidade dos empréstimos

		// Atualizar Salas que ja existiam
		if ($updated = array_diff(array_keys(array_diff_assoc($input_salas, $db_salas)), array_keys(array_diff_key($input_salas, $db_salas))))
		{
			$rows = array();
			foreach ($updated as $id)
			{
				$rows = array_add($rows, $input_predios[$id], ['sala' => $input_salas[$id]]);
			}
			$this->predio()->sync($rows);
		}

		// Atualizar Complementos que ja existiam
		if ($updated = array_diff(array_keys(array_diff_assoc($input_complementos, $db_complementos)),	array_keys(array_diff_key($input_complementos, $db_complementos))))
		{
			$rows = array();
			foreach ($updated as $id)
			{
				$rows = array_add($rows, $input_predios[$id], ['complemento' => $input_complementos[$id]]);
			}
			$this->predio()->sync($rows);
		}

		// Criar Vinculação com prédios que vieram no input
		if ($created = array_keys(array_diff_key($input_predios, $db_predios)))
		{
			$rows = array();
			foreach ($created as $id)
			{
				$values = array();
				if (isset($input_salas[$id]))
					$values = array_add($values, 'sala', $input_salas[$id]);
				if (isset($input_complementos[$id]))
					$values = array_add($values, 'complemento', $input_complementos[$id]);

				$rows = array_add($rows, $input_predios[$id], $values);
			}
			$this->predio()->attach($rows);
		}

	}

	public function telefone()
	{
		return $this->hasMany('App\AutoridadeTelefone', 'autoridades_id', 'id');
	}

	//public function syncOptions(array $options, $column = 'option')
	public function sincronizarTelefone(array $telefones, array $tipos_telefones)
	{
		$input_telefones       = array_filter($telefones);
		$input_tipos_telefones = array_filter($tipos_telefones);
		$db_telefones          = $this->telefone->lists('telefone', 'id');
		$db_tipos_telefones    = $this->telefone->lists('tipo_telefone', 'id');

		// Apagar telefones que não vieram no input
		if ($deleted = array_keys(array_diff_key($db_telefones, $input_telefones)))
		{
			$this->telefone()->whereIn('id', $deleted)->delete();
		}

		// Atualizar Telefones que ja existiam
		if ($updated = array_diff(array_keys(array_diff_assoc($input_telefones, $db_telefones)),array_keys(array_diff_key($input_telefones, $db_telefones))))
		{
			foreach ($updated as $id)
			{
				$this->telefone()->find($id)->update([
					'telefone' => $input_telefones[$id],
				]);
			}
		}

		// Atualizar Tipos de Telefones que ja existiam
		if ($updated = array_diff(array_keys(array_diff_assoc($input_tipos_telefones, $db_tipos_telefones)),	array_keys(array_diff_key($input_tipos_telefones, $db_tipos_telefones))))
		{
			foreach ($updated as $id)
			{
				$this->telefone()->find($id)->update([
					'tipo_telefone' => $input_tipos_telefones[$id],
				]);
			}
		}

		// Criar telefones que vieram no input
		if ($created = array_keys(array_diff_key($input_telefones, $db_telefones)))
		{
			foreach ($created as $id)
			{
				if (isset($input_tipos_telefones[$id]))
				{
					$values = array(
						'telefone'      => $input_telefones[$id],
						'tipo_telefone' => $input_tipos_telefones[$id]);
				}
				else
				{
					$values = array(
						'telefone'      => $input_telefones[$id],
						);
				}
				$new[] = $this->telefone()->getModel()->newInstance($values);
			}
			$this->telefone()->saveMany($new);
		}

	}

	public function carga()
	{
		return $this->hasMany('App\Carga', 'autoridades_id', 'id');
	}

}