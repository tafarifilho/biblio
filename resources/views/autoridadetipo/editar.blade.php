@extends('layouts.master')

@section('content')

	<h1>Atualizar Tipo de Autoridade</h1>
	{!! Form::model($autoridadetipo, array('route'=> array('autoridadetipo.editar', $autoridadetipo->id), 'class' => 'form-horizontal')) !!}

		@include ('autoridadetipo.formulario', ['tituloBotao' => 'Atualizar'])

	{!! Form::close() !!}

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')

@stop