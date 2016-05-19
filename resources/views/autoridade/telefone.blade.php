@extends('layouts.master')

@section('content')

	<h1>Cadastrar e Atualizar Telefones</h1>
	{!! Form::open(array('url'=>'autoridade/telefone', 'files' => true, 'class' => 'form-horizontal')) !!}

		<div class="form-group">
			{!! Form::label('autoridade', 'Autoridade', array('class'=>'col-sm-2 control-label')) !!}
			<div id="autoridade" class="col-sm-10">
				{!! Form::text('autoridade', $autoridade->nome, array('id'=>'autoridade', 'class'=>'typeahead form-control', 'placeholder'=>'Nome da Autoridade', 'disabled')) !!}
			</div>
			{!! Form::hidden('autoridade_id', $autoridade->id, array('id'=>'autoridade_id')) !!}
		</div>

		<div class="form-group">
			<div class="col-sm-2 col-sm-offset-10">
				<button id="adicionar" type="button" class="btn btn-info col-sm-12">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
				</button>
			</div>
		</div>

		<div id="telefones">

			@if ( count($autoridade->telefone) > 0 )

				@foreach ($autoridade->telefone as $telefone)

					<div id="telefone" class="form-group">

						{!! Form::label('telefones[]', 'Telefone', array('class'=>'col-sm-2 control-label')) !!}
						<div class="col-sm-4">
							{!! Form::input('tel', 'telefones[' . $telefone->id . ']', $telefone->telefone, array('class'=>'form-control', 'placeholder'=>'Telefone')) !!}
						</div>

						{!! Form::label('tipos_telefones[]', 'Tipo', array('class'=>'col-sm-2 control-label')) !!}
						<div class="col-sm-3">
							{!! Form::input('tel', 'tipos_telefones[' . $telefone->id . ']', $telefone->tipo_telefone, array('class'=>'form-control', 'placeholder'=>'Tipo')) !!}
						</div>

						<div class="col-sm-1">
							<button id="remover" type="button" class="telefone btn btn-danger col-sm-12">
								<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
							</button>
						</div>

					</div>

				@endforeach

			@endif

		</div>

		<div class="form-group">

			<div id="cadastrar" class="col-sm-offset-9 col-sm-3">
				<button type="submit" class="btn btn-success btn-lg col-sm-12">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Atualizar
				</button>
			</div>

		</div>

	{!! Form::close() !!}

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')
	{!! Html::script('js/adicionartelefone.js') !!}
	{!! Html::script('js/removertelefone.js') !!}
@stop