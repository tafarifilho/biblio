@extends('layouts.master')

@section('content')

	@if($usuarios)
	<div class="table-responsive">
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>id</th>
					<th>nome</th>
					<th>email</th>
					<th>grupos</th>
					<th>opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($usuarios as $usuario)
					@if ($usuario->estaRemovido())
						<tr class="danger">
					@elseif ($usuario->estaSuspenso())
						<tr class="warning">
					@elseif ($usuario->estaInativo())
						<tr class="info">
					@else
						<tr>
					@endif
						<th scope="row">{{ $usuario->id }}</th>
						<td>
							{{ $usuario->first_name }} 
							@if($usuario->last_name)
								<strong>{{ $usuario->last_name }} </strong>
							@endif
						</td>

						<td>
							{{ $usuario->email }} 
						</td>
						<td>
							@if($usuario->gruposNomes())
								@foreach ($usuario->gruposNomes() as $grupo)
									({{ $grupo }})
								@endforeach
							@endif
						</td>

						<td>
							<a href="{!! route('usuario.editar', [$usuario->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</a>
							
							<br />

							<a href="{!! route('usuario.resetar', [$usuario->id]) !!}" class="btn btn-default btn-xs btn-danger" role="button">
								<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
							</a>
							
							<br />

							@if ($usuario->estaSuspenso())
								<a href="{!! route('usuario.liberar', [$usuario->id]) !!}" class="btn btn-default btn-xs btn-success" role="button">
									<span class="glyphicon glyphicon-open" aria-hidden="true"></span>
								</a>
							@else
								<a href="{!! route('usuario.suspender', [$usuario->id]) !!}" class="btn btn-default btn-xs btn-danger" role="button">
									<span class="glyphicon glyphicon-save" aria-hidden="true"></span>
								</a>
							@endif

							<br />

							@if ($usuario->estaRemovido())
								<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#reativarModal{{$usuario->id}}">
									<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="reativarModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-success">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Reativar Usuário</h4>
											</div>
											<div class="modal-body">
												<strong>AVISO!!! </strong><br />
												<p>Você está prester a reativar um usuário apagada. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('usuario.reativar', [$usuario->id]) !!}" class="btn btn-success" role="button">
													<span class="glyphicon glyphicon-refresh" aria-hidden="true"> Reativar</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							@else
								<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarModal{{$usuario->id}}">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="apagarModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Apagar Usuário</h4>
											</div>
											<div class="modal-body">
												<strong>CUIDADO!!! </strong><br />
												<p>Você está prestes a apagar um usuário. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('usuario.apagar', [$usuario->id]) !!}" class="btn btn-danger" role="button">
													<span class="glyphicon glyphicon-remove" aria-hidden="true"> Apagar</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							@endif

							<hr />

							@if ($usuario->estaNoSamba())
								<a href="{!! route('samba.grupousuario', [$usuario->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
									<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
								</a>

								<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarSambaModal{{$usuario->id}}">
									<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="apagarSambaModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Apagar Usuário/Samba</h4>
											</div>
											<div class="modal-body">
												<strong>CUIDADO!!! </strong><br />
												<p>Você está prestes a apagar o usuário do Samba. Isto irá remover o acesso do usuário ao Samba, bem como apagar todas suas pastas e arquivos do servidor. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('samba.usuarioapagar', [$usuario->id]) !!}" class="btn btn-danger" role="button">
													<span class="glyphicon glyphicon-remove" aria-hidden="true"> Apagar</span>
												</a>
											</div>
										</div>
									</div>
								</div>

							@else

								<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#criarSambaModal{{$usuario->id}}">
									<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="criarSambaModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-success">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Criar Usuário/Samba</h4>
											</div>
											<div class="modal-body">
												<strong>AVISO!!! </strong><br />
												<p>Você está prester a criar o usuário no Samba. Isso implica na criação de diretórios e acessos ao sistema. Após deverá ser vinculado grupos para que o usuário tenha acesso às pastas corretas. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('samba.usuariocriar', [$usuario->id]) !!}" class="btn btn-success" role="button">
													<span class="glyphicon glyphicon-folder-open" aria-hidden="true"> Criar</span>
												</a>
											</div>
										</div>
									</div>
								</div>

							@endif

						</td>
					</tr>
				@endforeach

			</tbody>
		</table>
		</div>
	@endif

@stop

@section('styles')

@stop

@section('scripts')

@stop