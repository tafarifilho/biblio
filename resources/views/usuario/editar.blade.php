@extends('layouts.master')

@section('content')

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading">Editar</div>
					<div class="panel-body">

						{!! Form::model($usuario, ['route' => ['usuario.editar.post', $usuario->id]]) !!}

							<div class="form-group">
								{!! Form::label('first_name', 'Nome', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('first_name', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('last_name', 'Sobrenome', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('last_name', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('email', 'E-Mail Institucional', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('email', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('matricula', 'Matrícula', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::text('matricula', null, ['class' => 'form-control']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('grupos', 'Grupos', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::select('grupos[]', $grupos, $usuario->gruposId(), ['class' => 'form-control', 'multiple']) !!}
								</div>
							</div>

							<div class="form-group">
								{!! Form::label('ativado', 'Situação', array('class'=>'col-md-4 control-label')) !!}
								<div class="col-md-6">
									<div class="btn-group" data-toggle="buttons">
										<label class="btn btn-default
											@if ($usuario->activated == '0')
												active
											@endif ">
											<input type="radio" name="ativado" value="0" id="Ativado" autocomplete="off"> Desativado
									  </label>
										<label class="btn btn-default
											@if ($usuario->activated == '1')
												active
											@endif ">
											<input type="radio" name="ativado" value="1" id="Desativado" autocomplete="off"> Ativado
										</label>
									</div>
								</div>
							</div>

							<div class="form-group">
								<div class="col-md-6 col-md-offset-4">
									{!! Form::submit('Atualizar', ['class' => 'btn btn-primary']) !!}
								</div>
							</div>

						{!! Form::close() !!}
					</div>
				</div>
			</div>
		</div>
	</div>

@stop