@extends('layouts.master')

@section('content')

	@if($cargas)
	<h1>Baixar Carga</h1>

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
					<th data-field="tombo" data-switchable="false" class="hidden"></th>
					<th data-field="carga" data-sortable="true">carga</th>
					<th data-field="obra" >obra</th>
					<th data-field="autoridade"  data-sortable="true">autoridade</th>
					<th data-field="opcoes" >opções</th>
			</thead>
			<tbody>
				@foreach ($cargas as $carga)
					<tr>
						<td>{{ $carga->id }}</td>
						<td>
							@if ($carga->tombo)
								{{ $carga->tombo }}
							@endif
						</td>
						<td>
							{{ $carga->data_carga->format('d\/m\/Y') }}
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

						<button type="button" class="btn btn-default btn-xs btn-info" data-toggle="modal" data-target="#baixaModal{{$carga->id}}">
							<span class="glyphicon glyphicon-arrow-down" aria-hidden="true"></span>
						</button>

							<!-- Modal -->
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

						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
		</div>
	@endif

@stop

@section('styles')
	{!! Html::style('css/bootstrap-table.min.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/vendor/bootstrap-table.min.js') !!}
@stop