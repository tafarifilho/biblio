@extends('layouts.master')

@section('content')

	<h1>Cadastrar Autoridade</h1>
	{!! Form::open(array('url'=>'autoridade/cadastrar', 'files' => true, 'class' => 'form-horizontal')) !!}

		<div class="form-group">
			{!! Form::label('autoridade', 'Autoridade', array('class'=>'col-sm-2 control-label')) !!}
			<div id="autoridade" class="col-sm-10">
				{!! Form::text('autoridade', null, array('id'=>'autoridade', 'class'=>'typeahead form-control', 'placeholder'=>'Nome da Autoridade')) !!}
			</div>
			{!! Form::hidden('autoridade_id', null, array('id'=>'autoridade_id')) !!}
		</div>

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
					<label class="btn btn-default">
						<input type="radio" name="genero" value="m" id="generoM" autocomplete="off"> Masculino
				  </label>
					<label class="btn btn-default">
						<input type="radio" name="genero" value="f" id="generoF" autocomplete="off"> Feminino
					</label>
				</div>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('email', 'Email', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::email('email', null, array('id'=>'email', 'class'=>'form-control', 'placeholder'=>'Email')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('observacao', 'Observação', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('observacao', null, array('id'=>'observacao', 'class'=>'form-control', 'placeholder'=>'Observação')) !!}
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('tipo_autoridade_id', 'Tipo de Autoridades', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				<select id="tipo_autoridade_id" name="tipo_autoridade_id" class="form-control">
					<option value="" disabled selected>Escolha o tipo de autoridade</option>
					@if ($tipos_autoridades)
						@foreach ($tipos_autoridades as $tipo_autoridade)
							<option value="{{ $tipo_autoridade->id }}">{{ $tipo_autoridade->tipo }}</option>
						@endforeach
					@endif
				</select>
			</div>
		</div>

		<div class="form-group">
			{!! Form::label('predio', 'Prédio', array('class'=>'col-sm-2 control-label')) !!}
			<div id="predio" class="col-sm-10">
				{!! Form::text('predio', null, array('id'=>'predio', 'class'=>'typeahead form-control', 'placeholder'=>'Prédio')) !!}
			</div>
			{!! Form::hidden('predio_id', null, array('id'=>'predio_id')) !!}
		</div>

		<div class="form-group">
			{!! Form::label('sala', 'Sala ou Gabinete', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-4">
				{!! Form::text('sala', null, array('id'=>'sala', 'class'=>'form-control', 'placeholder'=>'Sala/Gabinete')) !!}
			</div>

			{!! Form::label('complemento', 'Complemento', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-4">
				{!! Form::text('complemento', null, array('id'=>'complemento', 'class'=>'form-control', 'placeholder'=>'Complemento')) !!}
			</div>
		</div>

		<div id="telefones">
			<div class="form-group">
				{!! Form::label('telefones[]', 'Telefone', array('class'=>'col-sm-2 control-label')) !!}
				<div class="col-sm-4">
					{!! Form::input('tel', 'telefones[]', null, array('class'=>'form-control', 'placeholder'=>'Telefone')) !!}
				</div>

				{!! Form::label('tipos_telefones[]', 'Tipo', array('class'=>'col-sm-2 control-label')) !!}
				<div class="col-sm-3">
					{!! Form::input('tel', 'tipos_telefones[]', null, array('class'=>'form-control', 'placeholder'=>'Tipo')) !!}
				</div>

				<div class="col-sm-1">
					<button id="adicionar" type="button" class="btn btn-info col-sm-12">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</button>
				</div>

			</div>
		</div>

		<div class="form-group">

			<div id="cadastrar" class="col-sm-offset-9 col-sm-3">
				<button type="submit" class="btn btn-success btn-lg col-sm-12">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Cadastrar
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
	{!! Html::script('js/predio.typeahead.js') !!}
	{!! Html::script('js/adicionartelefone.js') !!}
	{!! Html::script('js/removertelefone.js') !!}
	{!! Html::script('js/cadastrarautoridade.js') !!}

	{{-- Html::script('js/telefone.validate.js') --}}


@stop