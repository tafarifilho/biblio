@extends('layouts.master')

@section('content')

	<h1>Atualizar Prédio</h1>
	{!! Form::model($predio, array('route'=> array('predio.editar', $predio->id), 'class' => 'form-horizontal')) !!}

		@include ('predio.formulario', ['tituloBotao' => 'Atualizar'])

	{!! Form::close() !!}

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')

@stop