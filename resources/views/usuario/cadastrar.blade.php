@extends('layouts.master')

@section('content')

	<h1>Cadastrar Usuário</h1>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Cadastrar</div>
					<div class="panel-body">

						{!! Form::open(array('route'=>'usuario.cadastrar', 'class' => 'form-horizontal')) !!}

							<div class="form-group">
								{!! Form::label('first_name', 'Nome', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::text('first_name', old('first_name'), array('class'=>'form-control', 'placeholder'=>'Nome')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('last_name', 'Sobrenome', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::text('last_name', old('last_name'), array('class'=>'form-control', 'placeholder'=>'Sobrenome')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('email', 'E-mail Institucional', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::email('email', old('email'), array('class'=>'form-control', 'placeholder'=>'Email')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('matricula', 'Matrícula', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::text('matricula', old('matricula'), array('class'=>'form-control', 'placeholder'=>'Matrícula')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('password', 'Senha', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::password('password', array('class'=>'form-control')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('password_confirmation', 'Confirme a Senha', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::password('password_confirmation', array('class'=>'form-control')) !!}
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Cadastrar
									</button>
								</div>
							</div>

						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>

	<br><br>

@stop

@section('styles')

@stop

@section('scripts')

@stop