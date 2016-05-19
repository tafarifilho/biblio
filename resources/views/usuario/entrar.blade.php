@extends('layouts.master')

@section('content')

	<br /><br />
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Login</div>
					<div class="panel-body">

						{!! Form::open(array('route'=>'usuario.entrar', 'class' => 'form-horizontal')) !!}

							<div class="form-group">

								{!! Form::label('email', 'Email Institucional', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::input('email', 'email', old('email'), array('class'=>'form-control')) !!}
								</div>

							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Senha</label>
								<div class="col-md-6">
									<input type="password" class="form-control" name="password">
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<div class="checkbox">
										<label>
											<input type="checkbox" name="remember" checked="true"> Manter Logado
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">Entrar</button>

									<a class="btn btn-link" href="{{ url('/usuario/senha/email') }}">Esqueceu sua senha?</a>
								</div>
							</div>
						{!! Form::close() !!}

					</div>
				</div>
			</div>
		</div>
	</div>

@stop