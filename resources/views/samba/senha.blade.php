@extends('layouts.master')

@section('content')

	<h1>Alterar Senha do Samba</h1>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Alterar a Senha do Samba</div>
					<div class="panel-body">

						{!! Form::open(array('route'=>'samba.senha', 'class' => 'form-horizontal')) !!}

							<div class="form-group">
								{!! Form::label('password', 'Senha do AD:', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::password('password', array('class'=>'form-control')) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('password_confirmation', 'Confirme a Senha do AD:', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									{!! Form::password('password_confirmation', array('class'=>'form-control')) !!}
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									<button type="submit" class="btn btn-primary">
										Atualizar
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