@extends('layouts.master')

@section('content')

	<h1>Pesquisar</h1>
	{!! Form::open(array('route'=>'carga.realizar', 'class' => 'form-horizontal')) !!}

		<div class="form-group">
			{!! Form::label('autoridade', 'Autoridade', array('class'=>'col-sm-2 control-label')) !!}
			<div id="autoridade" class="col-sm-10">
				{!! Form::text('autoridade', null, array('id'=>'autoridade', 'class'=>'typeahead form-control', 'placeholder'=>'Nome da Autoridade')) !!}
			</div>
			{!! Form::hidden('autoridade_id', null, array('id'=>'autoridade_id')) !!}
		</div>

		<div id="enderecos" class="form-group">

		</div>

		<div class="form-group">
			<div id="cargas" class="col-sm-12">

			</div>
		</div>

		<div class="form-group">

			{!! Form::label('tombo', 'Tombo', array('class'=>'col-sm-2 control-label')) !!}
			<div id="tombo" class="col-sm-4">
				{!! Form::text('tombo', null, array('id'=>'tombo', 'class'=>'typeahead form-control', 'placeholder'=>'Tombo')) !!}
			</div>

			{!! Form::label('fixa', 'Localização', array('class'=>'col-sm-2 control-label')) !!}
			<div id="fixa" class="col-sm-4">
				{!! Form::text('fixa', null, array('id'=>'fixa', 'class'=>'typeahead form-control', 'placeholder'=>'Localização')) !!}
			</div>
		</div>

		<hr>

		<div class="form-group">
			<div class="col-sm-6">
				{!! Form::text('autor', null, array('id'=>'autor', 'class'=>'form-control', 'placeholder'=>'Autor')) !!}
			</div>

			<div class="col-sm-6">
				{!! Form::text('titulo', null, array('id'=>'titulo', 'class'=>'form-control', 'placeholder'=>'Título')) !!}
			</div>
		</div>

		<div class="form-group">

			<div class="col-sm-3">
				{!! Form::text('classificacao', null, array('id'=>'classificacao', 'class'=>'form-control', 'placeholder'=>'Classificação')) !!}
			</div>

			<div class="col-sm-3">
				{!! Form::text('notacao', null, array('id'=>'notacao', 'class'=>'form-control', 'placeholder'=>'Notação')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('volume', null, array('id'=>'volume', 'class'=>'form-control', 'placeholder'=>'Volume')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('edicao', null, array('id'=>'edicao', 'class'=>'form-control', 'placeholder'=>'Edição')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('ano', null, array('id'=>'ano', 'class'=>'form-control', 'placeholder'=>'Ano')) !!}
			</div>

		</div>

		<div class="form-group">

			<div class="col-sm-2">
				{!! Form::text('tombo', null, array('id'=>'tombo_conf', 'class'=>'form-control', 'placeholder'=>'Tombo')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('cs', null, array('id'=>'cs', 'class'=>'form-control', 'placeholder'=>'CS', 'maxlength' => '1')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('estante', null, array('id'=>'estante', 'class'=>'form-control', 'placeholder'=>'Estante', 'maxlength' => '2')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('prateleira', null, array('id'=>'prateleira', 'class'=>'form-control', 'placeholder'=>'Prateleira', 'maxlength' => '2')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('numero', null, array('id'=>'numero', 'class'=>'form-control', 'placeholder'=>'Número', 'maxlength' => '2')) !!}
			</div>

			<div class="col-sm-2">
				{!! Form::text('digito', null, array('id'=>'digito', 'class'=>'form-control', 'placeholder'=>'Dígito', 'maxlength' => '1')) !!}
			</div>

		</div>


		<div id="obra_id" class="form-group">

		</div>

		<div class="form-group">

			<div class="col-sm-offset-9 col-sm-3">
				<button id="adicionar" type="button" class="btn btn-info col-sm-12">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adicionar Obra
				</button>
			</div>

		</div>

		<hr>

		<div id="panelstyle" class="panel panel-info">
			<div class="panel-heading">Obras adicionadas</div>
			<div class="panel-body">

				<ul id="painel" class="list-group">


				</ul>

			</div>

		</div>

		<hr>

		<div class="form-group">

			{!! Form::label('destinatario', 'Destintário', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				<select id="destinatario" name="destinatario" class="form-control">
					<option value="" disabled selected>Escolha o destinatário</option>
					@if ($destinatarios)
						@foreach ($destinatarios as $destinatario)
							<option value="{{ $destinatario->id }}">{{ $destinatario->destinatario }}</option>
						@endforeach
					@endif
				</select>
			</div>

		</div>

		<div id="outrodestinatario">

		</div>

		<div class="form-group">

			{!! Form::label('solicitante', 'Solicitante', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('solicitante', null, array('id'=>'solicitante', 'class'=>'form-control', 'placeholder'=>'Nome da pessoa solicitante')) !!}
			</div>

		</div>

		<div class="form-group">

			{!! Form::label('email_solicitante', 'Email do Solicitante', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::email('email_solicitante', null, array('id'=>'email_solicitante', 'class'=>'form-control', 'placeholder'=>'Email do solicitante')) !!}
			</div>

		</div>

		<div class="form-group">

			{!! Form::label('tipo_solicitacao', 'Tipo de Solicitação', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				<select id="tipo_solicitacao" name="tipos_solicitacoes_id" class="form-control">
					<option value="" disabled selected>Escolha o tipo de solicitação</option>
					@if ($tiposSolicitacoes)
						@foreach ($tiposSolicitacoes as $tipoSolicitacao)
							<option value="{{ $tipoSolicitacao->id }}">{{ $tipoSolicitacao->tipo }}</option>
						@endforeach
					@endif
				</select>
			</div>

		</div>

		<div class="form-group">

			{!! Form::label('retirante', 'Retirante', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('retirante', null, array('id'=>'retirante', 'class'=>'form-control', 'placeholder'=>'Nome da pessoa retirante')) !!}
			</div>

		</div>

		<div class="form-group">

			{!! Form::label('observacao', 'Observação', array('class'=>'col-sm-2 control-label')) !!}
			<div class="col-sm-10">
				{!! Form::text('observacao', null, array('id'=>'observacao', 'class'=>'form-control', 'placeholder'=>'Observação')) !!}
			</div>

		</div>

		<div class="form-group">

			<div id="realizar" class="col-sm-offset-9 col-sm-3">
				<button type="submit" class="btn btn-success btn-lg col-sm-12">
					<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Realizar Carga
				</button>
			</div>

		</div>

	{!! Form::close() !!}

@stop

@section('styles')
	{!! Html::style('css/typeahead.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/vendor/handlebars.min.js') !!}
	{!! Html::script('js/vendor/typeahead.bundle.min.js') !!}

	{!! Html::script('js/autoridade.typeahead.js') !!}
	{!! Html::script('js/tombo.typeahead.js') !!}
	{!! Html::script('js/fixa.typeahead.js') !!}
	{!! Html::script('js/adicionarobra.js') !!}
	{!! Html::script('js/removerobra.js') !!}
	{!! Html::script('js/realizarcarga.js') !!}
	{!! Html::script('js/destinatario.js') !!}

@stop