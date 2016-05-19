@extends('layouts.master')

@section('content')

	@if($predios)

		<table id="eventsTable"
			data-toggle="table"
			data-click-to-select="true"
			data-checkbox-header="false"
			data-search="true"
			data-show-columns="true"
			data-toolbar="#toolbar">

			<thead>
				<tr>
					<th data-field="id">id</th>
					<th data-field="nome" data-sortable="true">nome</th>
					<th data-field="endereco" data-sortable="true">endereço</th>
					<th data-field="opcoes">opções</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($predios as $predio)
					@if ($predio->deleted_at)
						<tr class="danger">
					@else
						<tr>
					@endif
						<td>{{ $predio->id }}</th>

						<td>{{ $predio->predio }}</td>
						<td>
							@if ($predio->endereco)
								{{ $predio->endereco }}
							@endif
							@if ($predio->numero)
								, nº {{ $predio->numero }}
							@endif
							@if ($predio->complemento)
								, {{ $predio->complemento }}
							@endif
							@if ($predio->cidade)
								. {{ $predio->cidade }}
							@endif
							@if ($predio->estado)
								/{{ $predio->estado }}.
							@endif
							@if ($predio->cep)
								CEP: {{ $predio->cep }}.
							@endif
							@if ($predio->tronco)
								Telefone Tronco: {{ $predio->tronco }}.
							@endif
						</td>

						<td>
							
							<a href="{!! route('predio.editar', [$predio->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</a>

							@if ($predio->deleted_at)
								<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#reativarModal{{$predio->id}}">
									<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="reativarModal{{$predio->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-success">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Reativar Prédio</h4>
											</div>
											<div class="modal-body">
												<strong>AVISO!!! </strong><br />
												<p>Você está preste a reativar um prédio apagado. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('predio.reativar', [$predio->id]) !!}" class="btn btn-success" role="button">
													<span class="glyphicon glyphicon-refresh" aria-hidden="true"> Reativar</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							@else
								<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarModal{{$predio->id}}">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="apagarModal{{$predio->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Apagar Prédio</h4>
											</div>
											<div class="modal-body">
												<strong>CUIDADO!!! </strong><br />
												<p>Você está prester a apagar um prédio. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('predio.apagar', [$predio->id]) !!}" class="btn btn-danger" role="button">
													<span class="glyphicon glyphicon-remove" aria-hidden="true"> Apagar</span>
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
	@endif

@stop

@section('styles')
	{!! Html::style('css/bootstrap-table.min.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/vendor/bootstrap-table.min.js') !!}
@stop