@extends('layouts.master')

@section('content')

	@if($cargas)

	{!! Form::open(array('route'=>'carga.renovar.post', 'class' => 'form-horizontal')) !!}

	<h1>Total de cargas em aberto: {{ count($cargas) }}</h1><br>

	<table id="eventsTable"
			data-toggle="table"
			data-click-to-select="true"
			data-checkbox-header="false"
			data-search="true"
			data-show-columns="true"
			data-toolbar="#toolbar"
			data-id-field="id"
			data-select-item-name="id[]">

			<thead>
				<tr>
					<th data-field="state" data-checkbox="true"></th>
					<th data-field="id">id</th>
					<th data-field="tombo" data-switchable="false" class="hidden">tombo</th>
					<th data-field="carga" data-sortable="true">carga</th>
					<th data-field="obra">obra</th>
					<th data-field="autoridade" data-sortable="true">autoridade</th>
					<th data-field="data_cobranca" data-sortable="true">cobrança</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($cargas as $carga)
					@if ($carga->deleted_at)
						<tr class="danger">
					@else
						<tr>
					@endif
						<td></td>
						<td>{{ $carga->id }}</td>

						<td>
							@if ($carga->tombo)
								{{ $carga->tombo }}
							@endif
						</td>

						<td>
							<span class="hidden">{{ $carga->data_carga->format('Y\/m\/d') }}</span>
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
							<span class="hidden">{{ $carga->data_cobranca->format('Y\/m\/d') }}</span>
							{{ $carga->data_cobranca->format('d\/m\/Y') }}
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	@endif

	<div class="botao-flutuador">

		<button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#renovarModal">
			<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Renovar Carga
		</button>

		<div class="modal fade" id="renovarModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Renovar Carga</h4>
					</div>

					<div class="modal-body">

						<div class="form-group">
							<div class="col-sm-12">
								{!! Form::text('contato', null, array('id'=>'contato', 'class'=>'form-control', 'placeholder'=>'Contato', 'autofocus')) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								{!! Form::text('observacao', null, array('id'=>'observacao', 'class'=>'form-control', 'placeholder'=>'Observação')) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								<select id="prazo" name="prazo" class="form-control">
									<option value="" disabled selected>Escolha o Prazo</option>
									@if ($autoridadesTipos)
										@foreach ($autoridadesTipos as $autoridadeTipo)
											<option value="{{ $autoridadeTipo->prazo }}">{{ $autoridadeTipo->prazo }} dias - {{ $autoridadeTipo->tipo }}</option>
										@endforeach
									@endif
								</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-12">
								{!! Form::text('excepcional', null, array('id'=>'excepcional', 'class'=>'form-control', 'placeholder'=>'Prazo Excepcional')) !!}
							</div>
						</div>
				
					</div> <!-- Fim do Body -->

					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>

						<button id="renovarCarga" type="submit" class="btn btn-primary">
							<span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Renovar Carga
						</button>

					</div>

				</div>
			</div>
		</div>

	</div>

	{!! Form::close() !!}

@stop

@section('styles')
	{!! Html::style('css/bootstrap-table.min.css') !!}
@stop

@section('scripts')
	{!! Html::script('js/vendor/bootstrap-table.min.js') !!}
	{!! Html::script('js/renovarcarga.js') !!}

	<script type="text/javascript">

		$(document).on('shown.bs.modal', function(e){
			$('[autofocus]', e.target).focus();
		});

	</script>
@stop