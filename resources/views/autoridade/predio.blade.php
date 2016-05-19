@extends('layouts.master')

@section('content')

	<h1>Cadastrar e Atualizar Prédios</h1>
	{!! Form::open(array('url'=>'autoridade/predio', 'files' => true, 'class' => 'form-horizontal')) !!}

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

		<div id="predios" class="col-sm-12">

			@if ( count($autoridade->predio) > 0 )

				@foreach ($autoridade->predio as $predio)

					<div id="predio" class="form-group">

						<div class="form-group">
							{!! Form::label('predio', 'Prédio', array('class'=>'col-sm-2 control-label')) !!}
							<div id="predio" class="col-sm-9">
								{!! Form::text('predio[' . $predio->pivot->id . ']', $predio->predio, array('id'=>'predio', 'class'=>'typeadhead form-control', 'placeholder'=>'Prédio', 'disabled')) !!}
							</div>
							{!! Form::hidden('predio_id[' . $predio->pivot->id . ']', $predio->id, array('id'=>'predio_id')) !!}

							<div class="col-sm-1">
								<button id="remover" type="button" class="predio btn btn-danger col-sm-12">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
							</div>
						</div>

						<div class="form-group">
							{!! Form::label('sala', 'Sala ou Gabinete', array('class'=>'col-sm-2 control-label')) !!}
							<div class="col-sm-3">
								{!! Form::text('sala[' . $predio->pivot->id . ']', $predio->pivot->sala, array('id'=>'sala', 'class'=>'form-control', 'placeholder'=>'Sala/Gabinete')) !!}
							</div>

							{!! Form::label('complemento', 'Complemento', array('class'=>'col-sm-2 control-label')) !!}
							<div class="col-sm-4">
								{!! Form::text('complemento[' . $predio->pivot->id . ']', $predio->pivot->complemento, array('id'=>'complemento', 'class'=>'form-control', 'placeholder'=>'Complemento')) !!}
							</div>
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
	{!! Html::style('css/typeahead.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/vendor/handlebars.min.js') !!}
	{!! Html::script('js/vendor/typeahead.bundle.min.js') !!}

	{!! Html::script('js/predio.typeahead.js') !!}
	{!! Html::script('js/adicionarpredio.js') !!}
	{!! Html::script('js/removerpredio.js') !!}
@stop