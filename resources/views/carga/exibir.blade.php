@extends('layouts.master')

@section('content')

	<div class="jumbotron">
		<div class="row">
			<div class="col-sm-2">
				@if($cargas[0]->autoridade->imagem)
					<img src="{{ route('autoridade.imagemmini', [$cargas[0]->autoridade->id]) }}" alt="{{ $cargas[0]->autoridade->nome }}" class="img-circle img-responsive">
				@endif
				</div>
			<div class="col-sm-10">
				<h2>{{ $cargas[0]->autoridade->nome }} <br />
					<small>
						({{ $cargas[0]->autoridade->tipo->tipo }})
						@if ($cargas[0]->autoridade->email)
							<br />Email: {{ $cargas[0]->autoridade->email }}
						@endif
					</small>
				</h2>
			</div>
		</div>
	</div>

	@foreach ($cargas as $carga)
		<div class="jumbotron">
			<p>
				@if($carga->deleted_at)
					<div class="alert alert-danger" role="alert">Carga Cancelada</div>
				@endif

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

				@if($carga->classificacao)
					<strong><br />Chamada: </strong>{{ $carga->classificacao }}
					@if($carga->notacao)
						/ {{ $carga->notacao }}
					@endif
				@endif

				@if($carga->tombo)
					<strong><br />Tombo: </strong>{{ $carga->tombo }}
				@endif

				@if($carga->estante)
					<strong><br />Localização: </strong>
					@if($carga->cs)
						CS{{ $carga->cs }}/
					@endif
					@if($carga->estante)
						E{{ $carga->estante }}
					@endif
					@if($carga->prateleira)
						/P{{ $carga->prateleira }}
					@endif
					@if($carga->numero)
						/N{{ $carga->numero }}
					@endif
					@if($carga->digito)
						-{{ $carga->digito }}
					@endif
				@endif

				<div class="row">
					<div class="col-sm-4">
						<p class="bg-success">
							<strong>Carga</strong>
							<br />
							{{ $carga->data_carga->format('d\/m\/Y \(H:i \h\s\)') }}
							<br />
							{{ $carga->funcionariocarga->first_name }} {{ $carga->funcionariocarga->last_name }}
						</p>
					</div>
					@if($carga->data_baixa)
						<div class="col-sm-4">
							<p class="bg-info">
								<strong>Baixa</strong>
								<br />
								{{ $carga->data_baixa->format('d\/m\/Y \(H:i \h\s\)') }}
								<br />
								{{ $carga->funcionariobaixa->first_name }} {{ $carga->funcionariobaixa->last_name }}
							</p>
						</div>
					@endif
					@if($carga->data_cobranca)
						<div class="col-sm-4">
							<p class="bg-warning">
								<strong>Última Cobrança</strong>
								<br />
								{{ $carga->data_cobranca->format('d\/m\/Y') }}
							</p>
						</div>
					@endif
				</div>
			</p>

			<p>
				@if($carga->destinatarios_id)
					<p>
						<strong>Destinatário: </strong>
						{{ $carga->destinatario->destinatario }}
						@if($carga->destinatarios_id == 4)
							<strong>(
								{!! $carga->destinatarioFisico->autoridade->nome !!} 
								- {!! $carga->destinatarioFisico->autoridade->tipo->tipo !!}
	 							@if ($carga->destinatarioFisico->predio->predio)
									{{ $carga->destinatarioFisico->predio->predio }} -
								@endif
								@if ($carga->destinatarioFisico->predio->endereco)
									{{ $carga->destinatarioFisico->predio->endereco }}
								@endif
								@if ($carga->destinatarioFisico->predio->numero)
									nº {{ $carga->destinatarioFisico->predio->numero }}
								@endif
								@if ($carga->destinatarioFisico->predio->complemento)
									, {{ $carga->destinatarioFisico->predio->complemento }}
								@endif
								@if ($carga->destinatarioFisico->predio->sala)
									, {{ $carga->destinatarioFisico->predio->sala }}
								@endif
								@if ($carga->destinatarioFisico->sala)
									, Sala/Gabinete: {{ $carga->destinatarioFisico->sala }}
								@endif
								@if ($carga->destinatarioFisico->complemento)
									, {{ $carga->destinatarioFisico->complemento }}
								@endif
							)</strong>
						@endif
					</p>
				@endif
			</p>

			<p>
				@if($carga->solicitante)
					<p>
						<strong>Solicitante: </strong>
						{{ $carga->solicitante }}
						@if($carga->email_solicitante)
							({{ $carga->email_solicitante }})
						@endif
					</p>
				@endif
			</p>
			<p>
				@if($carga->tiposolicitacao->tipo)
					<p>
						<strong>Solicitado: </strong>
						{{ $carga->tiposolicitacao->tipo }}
					</p>
				@endif
			</p>
			<p>
				@if($carga->retirante)
					<p>
						<strong>Retirante: </strong>
						{{ $carga->retirante }}
					</p>
				@endif
			</p>
			<p>
				@if($carga->observacao)
					<p>
						<strong>Observação: </strong>
						{{ $carga->observacao }}
					</p>
				@endif
			</p>
			@if(count($carga->controles))
				<p>
					<strong>Controles:</strong>
					<div class="table-responsive">
						<table class="table table-hover table-condensed">
							<thead>
								<tr>
									<th>data</th>
									<th>controle</th>
									<th>funcionário</th>
								</tr>
							</thead>
							<tbody>
							
								@foreach ($carga->controles as $controle)
									<tr>
										<td>
											{{ $controle->created_at->format('d\/m\/Y') }}
										</td>
										<td>
											{{ $controle->controle }}
										</td>
										<td>
											{{ $controle->funcionario->first_name }} {{ $controle->funcionario->last_name }}
										</td>
									</tr>
								@endforeach

							</tbody>
						</table>
					</div>
				</p>
			@endif
		</div>
	@endforeach

@stop

@section('styles')

@stop

@section('scripts')

@stop