@extends('layouts.master')

@section('content')

	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-2">
				@if($autoridade->imagem)
					<img src="{{ route('autoridade.imagemmini', [$autoridade->id]) }}" alt="{{ $autoridade->nome }}" class="img-circle img-responsive">
				@endif
				</div>
			<div class="col-sm-10">
				<h2>{{ $autoridade->nome }} <br />
					<small>
						({{ $autoridade->tipo->tipo }})
						@if ($autoridade->email)
							<br />Email: {{ $autoridade->email }}
						@endif
						@if ($autoridade->observacao)
							<br /><strong>{{ $autoridade->observacao }}</strong>
						@endif
					</small>
				</h2>
			</div>
		</div>
	</div>

	@if (count ($autoridade->telefone) > 0 )
		<div class="jumbotron">
			<p><strong>Telefone(s)</strong>:
			@foreach ($autoridade->telefone as $telefone)
				<br/>- {{ $telefone->tipo_telefone }} {{ $telefone->telefone}}
			@endforeach
			</p>
		</div>
	@endif

	@if ($autoridade->predio)
		<div class="jumbotron">
			<p><strong>Endereço(s)</strong>:
			@foreach ($autoridade->predio as $predio)
				<br/>- <strong>{{ $predio->predio }}</strong>
				@if ($predio->pivot->sala)
					<br /><strong>Sala/Gabinete: </strong>{{ $predio->pivot->sala }}
				@endif
				@if ($predio->pivot->complemento)
					 <strong>Complemento: </strong>{{ $predio->pivot->complemento }}
				@endif
				<br />
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
			@endforeach
			</p>
		</div>
	@endif

	@if ($autoridade->carga)
		<div class="jumbotron">

			<h2>Cargas realizadas: {{ $autoridade->carga()->count() }}</h2>
			@if ($autoridade->carga()->abertas()->count() > 0)
				<h2>Cargas em Aberto: {{ $autoridade->carga()->abertas()->count() }}</h2>
			@endif

			<table id="eventsTable"
					data-toggle="table"
					data-search="true"
					data-show-columns="true"
					data-toolbar="#toolbar">

					<thead>
						<tr>
							<th data-field="datacarga" data-sortable="true">carga</th>
							<th data-field="databaixa" data-sortable="true">baixa</th>
							<th data-field="obra">obra</th>
							<th data-field="opcoes">opções</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($autoridade->carga()->velhas()->get() as $carga)

							@if ($carga->data_baixa)
								<tr>
							@else
								<tr class="info">
							@endif

								<td>{{ $carga->data_carga->format('d\/m\/Y \(H:i \h\s\)') }}</td>
								<td>
									@if($carga->data_baixa)
										{{ $carga->data_baixa->format('d\/m\/Y \(H:i \h\s\)') }}<br />
									@endif
								</td>
								<td>{!! $carga->obraEstruturada() !!}</td>
								<td><a href="{{ route('carga.exibir', [$carga->carga])}}" class="btn btn-primary btn-sm">Detalhes</a><br /></td>

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