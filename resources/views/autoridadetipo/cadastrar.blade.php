@extends('layouts.master')

@section('content')

	<h1>Cadastrar Tipo de Autoridade</h1>

	{!! Form::open(array('route'=>'autoridadetipo.cadastrar', 'class' => 'form-horizontal')) !!}

		@include ('autoridadetipo.formulario', ['tituloBotao' => 'Cadastrar'])

	{!! Form::close() !!}

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')

@stop