@extends('layouts.master')

@section('content')

	@if($autoridades)

	<table id="eventsTable"
			data-toggle="table"
			data-search="true"
			data-show-columns="true"
			data-toolbar="#toolbar">

			<thead>
				<tr>
					<th data-field="id">id</th>
					<th data-field="nome" data-sortable="true">nome</th>
					<th data-field="cargo" data-sortable="true">cargo</th>
					<th data-field="opcoes">opções</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($autoridades as $autoridade)
					@if ($autoridade->deleted_at)
						<tr class="danger">
					@else
						<tr>
					@endif
						<td>{{ $autoridade->id }}</th>

						<td>{{ $autoridade->nome }}</td>
						<td>{{ $autoridade->tipo->tipo }}</td>

						<td>
							
							<a href="{!! route('autoridade.exibir', [$autoridade->id]) !!}" class="btn btn-default btn-xs" role="button">
								<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
							</a>

							<br />

							<a href="{!! route('autoridade.editar', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</a>

							<a href="{!! route('autoridade.telefone', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span>
							</a>

							<a href="{!! route('autoridade.predio', [$autoridade->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
							</a>

							@if ($autoridade->deleted_at)
								<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#reativarModal{{$autoridade->id}}">
									<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="reativarModal{{$autoridade->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-success">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Reativar Autoridade</h4>
											</div>
											<div class="modal-body">
												<strong>AVISO!!! </strong><br />
												<p>Você está preste a reativar uma autoridade apagada. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('autoridade.reativar', [$autoridade->id]) !!}" class="btn btn-success" role="button">
													<span class="glyphicon glyphicon-refresh" aria-hidden="true"> Reativar</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							@else
								<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarModal{{$autoridade->id}}">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="apagarModal{{$autoridade->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
									<div class="modal-dialog modal-sm">
										<div class="modal-content">
											<div class="modal-header bg-danger">
												<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
												<h4 class="modal-title" id="myModalLabel">Apagar Autoridade</h4>
											</div>
											<div class="modal-body">
												<strong>CUIDADO!!! </strong><br />
												<p>Você está prester a apagar a autoridade. <br />
												Você tem certeza?</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Não</button>
												<a href="{!! route('autoridade.apagar', [$autoridade->id]) !!}" class="btn btn-danger" role="button">
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