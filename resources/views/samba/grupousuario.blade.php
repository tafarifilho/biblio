@extends('layouts.master')

@section('content')

	<code>
		<strong>[Pasta Home]</strong><br>
		- Cada usuário tem sua pasta com acesso exclusivo<br>
		<br>
		<strong>[Diretoria]</strong><br>
		Leitura:  Somente usuários do grupo Diretoria<br>
		Gravação: Somente usuários do grupo Diretoria<br>
		<br>
	</code>

	<br /><hr />

	<h2>{{ $usuario->last_name}}, {{ $usuario->first_name}}</h2>

	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<div class="panel-heading"><strong>Alterar Grupos/Samba do Usuário:</strong></div>
					<div class="panel-body">

						<div class="col-md-4"><strong>Grupos Anteriores:</strong></div>
						<div class="col-md-6">{{ $gruposUsuarios }}</div>

						<br />

						{!! Form::open(array('route' => ['samba.grupousuario.post', $usuario->id])) !!}

							<div class="form-group">
								{!! Form::label('grupos', 'Novos Grupos', ['class' => 'col-md-4 control-label']) !!}
								<div class="col-md-6">
									{!! Form::select('grupos[]', $grupos, null, ['class' => 'form-control', 'multiple']) !!}
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