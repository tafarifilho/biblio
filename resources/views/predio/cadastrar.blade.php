@extends('layouts.master')

@section('content')

	<h1>Cadastrar Prédio</h1>

	{!! Form::open(array('route'=>'predio.cadastrar', 'class' => 'form-horizontal')) !!}

		@include ('predio.formulario', ['tituloBotao' => 'Cadastrar'])

	{!! Form::close() !!}

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')

@stop