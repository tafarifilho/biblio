@extends('layouts.master')

@section('content')

	<h1>Cadastrar Grupo Samba</h1>

	{!! Form::open(array('route'=>'samba.grupo.post', 'class' => 'form-horizontal')) !!}

		<div class="jumbotron">
			<h3>Grupos Existentes</h3>
			<p>
				@if ($grupos)
					<ul>
						@foreach ($grupos as $grupo)
							<li>
								{{ $grupo }}  
								{!! link_to_route('samba.grupoapagar', 'Apagar', $grupo, array('class' => 'btn btn-danger btn-xs')) !!}
							</li>
						@endforeach
					</ul>
				@endif				
			</p>	
		</div>

		<div class="form-group">
			{!! Form::label('grupo', 'Novo Grupo', array('class'=>'col-sm-2 control-label')) !!}
			<div id="autoridade" class="col-sm-10">
				{!! Form::text('grupo', null, array('id'=>'grupo', 'class'=>'form-control', 'placeholder'=>'Nome do Grupo')) !!}
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

@stop

@section('styles')

@stop

@section('scripts')

@stop