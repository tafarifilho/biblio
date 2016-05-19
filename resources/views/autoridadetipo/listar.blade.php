@extends('layouts.master')

@section('content')

	@if($autoridadestipos)

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
					<th data-field="tipo" data-sortable="true">tipo</th>
					<th data-field="tratamento" data-sortable="true">tratamento</th>
					<th data-field="abreviado" data-sortable="true">abreviado</th> 
					<th data-field="prazo" data-sortable="true">prazo</th> 
					<th data-field="opcoes">opções</th>
				</tr>
			</thead>
			<tbody>

				@foreach ($autoridadestipos as $autoridadetipo)
					@if ($autoridadetipo->deleted_at)
						<tr class="danger">
					@else
						<tr>
					@endif
						<td>{{ $autoridadetipo->id }}</th>

						<td>{{ $autoridadetipo->tipo }}</td>
						<td>{{ $autoridadetipo->tratamento }}</td>
						<td>{{ $autoridadetipo->abreviado }}</td>
						<td>{{ $autoridadetipo->prazo }}</td>

						<td>

							<a href="{!! route('autoridadetipo.editar', [$autoridadetipo->id]) !!}" class="btn btn-default btn-xs btn-warning" role="button">
								<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
							</a>

							@if ($autoridadetipo->deleted_at)
								<button type="button" class="btn btn-default btn-xs btn-success" data-toggle="modal" data-target="#reativarModal{{$autoridadetipo->id}}">
									<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="reativarModal{{$autoridadetipo->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
												<a href="{!! route('autoridadetipo.reativar', [$autoridadetipo->id]) !!}" class="btn btn-success" role="button">
													<span class="glyphicon glyphicon-refresh" aria-hidden="true"> Reativar</span>
												</a>
											</div>
										</div>
									</div>
								</div>
							@else
								<button type="button" class="btn btn-default btn-xs btn-danger" data-toggle="modal" data-target="#apagarModal{{$autoridadetipo->id}}">
									<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
								</button>
								<div class="modal fade" id="apagarModal{{$autoridadetipo->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
												<a href="{!! route('autoridadetipo.apagar', [$autoridadetipo->id]) !!}" class="btn btn-danger" role="button">
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