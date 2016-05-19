@extends('layouts.master')

@section('content')

	@if($cargas)
	<div class="table-responsive hidden-print">
		<table class="table table-striped table-condensed">
			<thead>
				<tr>
					<th>id</th>
					<th>carga</th>
					<th>baixa</th>
					<th>obra</th>
					<th>autoridade</th>
					<th>opções</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($cargas as $carga)
					@if ($carga->deleted_at)
						<tr class="danger">
					@else
						<tr>
					@endif
						<th scope="row">{{ $carga->id }}</th>
						<td>
							{{ $carga->data_carga->format('d\/m\/Y') }}
						</td>
						<td>
							@if($carga->data_baixa)
								{{ $carga->data_baixa->format('d\/m\/Y') }}
							@endif
						</td>

						<td>
							@if($carga->nome)
								<strong>{{ $carga->nome }}. </strong>
							@endif

							{{ $carga->titulo }}.

							@if($carga->volume)
								<strong>{{ $carga->volume }}.</strong>
							@endif

							@if($carga->edicao)
								{{ $carga->edicao }}. 
							@endif

							@if($carga->ano)
								{{ $carga->ano }}.
							@endif
						</td>
						<td>{{ $carga->autoridade->nome }}</td>
						<td>

							<a href="{!! route('carga.imprimir', [$carga->carga]) !!}" class="btn btn-default btn-xs" data-toggle="modal" data-target="#myModal{{$carga->id}}">
								<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
							</a>
    
							<div id="myModal{{$carga->id}}" class="modal fade">
								<div class="modal-dialog modal-lg">
									<div id="printThis{{$carga->id}}" class="modal-content">

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
										<button type="button" class="btn btn-primary" onclick="printElement(printThis{{$carga->id}})">Imprimir</button>
									</div>
								</div>
							</div>

							<div>
								<a href="{!! route('carga.exibir', [$carga->carga]) !!}" class="btn btn-default btn-xs" role="button">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</a>

								<br />

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Realizar Baixa')))

									@if(!$carga->data_baixa)
										<button type="button" class="btn btn-default btn-xs btn-info" data-toggle="modal" data-target="#baixaModal{{$carga->id}}">
											<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
										</button>
										<div class="modal fade" id="baixaModal{{$carga->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Baixar Carga</h4>
													</div>
													<div class="modal-body">
														Você está prester a realizar a baixa. Concorda?
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
														<a href="{!! route('carga.realizarbaixa', [$carga->id]) !!}" class="btn btn-primary" role="button">
															<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"> Baixar</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									@endif

								@endif

								@if($usuarioAtual->inGroup(\Sentry::findGroupByName('Grupo de Realizar Baixa')))

									<a href="{!! route('carga.editar', [$carga->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
										<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</a><br>

									@if ($carga->deleted_at)
										<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#reativarModal{{$carga->id}}">
											<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
										</button>
										<div class="modal fade" id="reativarModal{{$carga->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<div class="modal-header bg-success">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Reativar Carga</h4>
													</div>
													<div class="modal-body">
														<strong>AVISO!!! </strong><br />
														<p>Você está prester a reativar uma carga apagada. <br />
														Você tem certeza?</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
														<a href="{!! route('carga.reativar', [$carga->id]) !!}" class="btn btn-success" role="button">
															<span class="glyphicon glyphicon-refresh" aria-hidden="true"> Reativar</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									@else
										<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarModal{{$carga->id}}">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</button>
										<div class="modal fade" id="apagarModal{{$carga->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-dialog modal-sm">
												<div class="modal-content">
													<div class="modal-header bg-danger">
														<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
														<h4 class="modal-title" id="myModalLabel">Apagar Carga</h4>
													</div>
													<div class="modal-body">
														<strong>CUIDADO!!! </strong><br />
														<p>Você está prester a apagar a carga. <br />
														Você tem certeza?</p>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
														<a href="{!! route('carga.apagar', [$carga->id]) !!}" class="btn btn-danger" role="button">
															<span class="glyphicon glyphicon-remove" aria-hidden="true"> Apagar</span>
														</a>
													</div>
												</div>
											</div>
										</div>
									@endif

								@endif

							</div> <!-- end -->

						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>
	@endif

	<div class="hidden-print">
		{!! $cargas->render() !!}
	</div>

@stop

@section('styles')
	{!! Html::style('css/printable.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/printable.js') !!}
@stop