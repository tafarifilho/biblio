@extends('layouts.master')

@section('content')
	@if($cargas)

        <h1>Total de cargas em aberto: {{ count($cargas) }}</h1><br>

		<table id="eventsTable"
                       data-toggle="table"
                       data-click-to-select="false"
                       data-checkbox-header="false"
                       data-search="true"
                       data-show-columns="true"
                       data-toolbar="#toolbar"
                       data-id-field="id"
                       data-select-item-name="id[]">

			<thead>
				<tr>
					<th data-field="id">id</th>
					<th data-field="tombo" data-switchable="false" class="hidden"></th>
					<th data-field="carga" data-sortable="true">carga</th>
					<th data-field="obra" data-sortable="true">obra</th>
					<th data-field="autoridade" data-sortable="true">autoridade</th>
					<th data-field="opcoes">opções</th>
				</tr>
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
							<div>
								<a href="{!! route('carga.exibir', [$carga->carga]) !!}" class="btn btn-default btn-xs" role="button">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</a>

								<br />

							</div> <!-- end -->

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
