@extends('layouts.master')

@section('content')

	<h1>Editar Autoridade</h1>
	{!! Form::open(array('url'=>'autoridade/editar', 'files' => true, 'class' => 'form-horizontal')) !!}

		<div class="form-group">
			{!! Form::label('autoridade', 'Autoridade', array('class'=>'col-sm-2 control-label')) !!}
			<div id="autoridade" class="col-sm-10">
				{!! Form::text('autoridade', $autoridade->nome, array('id'=>'autoridade', 'class'=>'typeahead form-control', 'placeholder'=>'Nome da Autoridade')) !!}
			</div>
			{!! Form::hidden('autoridade_id', $autoridade->id, array('id'=>'autoridade_id')) !!}
		</div>

		@if ($autoridade->imagem)
			<div class="col-sm-offset-2">
				<img src="{{ route('autoridade.imagemmini', [$autoridade->id]) }}" alt="{{ $autoridade->nome }}" class="img-thumbnail img-responsive ">
			</div>
		@endif

		<div class="form-group">
			{!! Form::label('foto', 'Foto', array('class'=>'col-sm-2 control-label')) !!}
			<div id="foto" class="col-sm-10">
				{!! Form::file('foto', array('accept'=>'image/*')) !!}
			</div>
		</div>

		<div class="form-group" id="genero">
			{!! Form::label('genero', 'Gênero', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default
						@if ($autoridade->genero == 'm')
							active
						@endif ">
						<input type="radio" name="genero" value="m" id="generoM" autocomplete="off"> Masculino
				  </label>
					<label class="btn btn-default
						@if ($autoridade->genero == 'f')
							active
						@endif ">
						<input type="radio" name="genero" value="f" id="generoF" autocomplete="off"> Feminino
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('email', 'Email', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::email('email', $autoridade->email, array('id'=>'email', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('observacao', 'Observação', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('observacao', $autoridade->observacao, array('id'=>'observacao', 'class'=>'form-control', 'placeholder'=>'Observação')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('tipo_autoridade_id', 'Tipo de Autoridades', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
			{!! Form::select('tipo_autoridade_id', $tipos_autoridades, $autoridade->tipo->id, array('class'=>'form-control')) !!}
			</div>
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

	{!! Html::script('js/autoridade.typeahead.js') !!}
	{!! Html::script('js/cadastrarautoridade.js') !!}

@stop