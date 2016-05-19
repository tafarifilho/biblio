<!DOCTYPE html>
<html>
<head>
	<title>Recibo de Mala</title>
</head>
<style type="text/css">

	table
	{
		width: 630px;
	}

</style>
<body>

{{-- XGH --}}
@if ($cargas[0]->destinatario->id == 1 || $cargas[0]->destinatario->id == 4 || $cargas[0]->destinatario->id == 5)

	<table style="border: 0px;">
		<tr style="height:55px;vertical-align: middle;">
			<td style="text-align:center;width:100px;">
				{!! Html::image('images/brasao.png', 'Brasão', ['style' => 'height: 50px;width: 88px;'], false) !!}
			</td>
			<td style="text-align:center;width:450px;">
				<strong>BIBLIOTECA</strong><br>
				-- biblioteca --
			</td>
			<td style="text-align:right;width:100px;">
				{{ $cargas[0]->data_carga->format('d\/m\/Y') }}
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;">
		<tr>
			<td>
				Expedidor:
				</td>
			</td>
		</tr>
		<tr>
			<td style="text-align:center">
				<strong>Biblioteca - Serviço de Atendimento</strong>
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;text-align:justify">
		<tr>
			<td style="width:90px">Remete:</td>
			<td style="width:560px">
				<strong>
					<span style="font-size: smaller;">
						Livro(s)
						@if ( $cargas[0]->destinatario->id == 4 )
							({{ $cargas[0]->autoridade->nome }})
						@endif
						:<br>
						@foreach ($cargas as $carga)
							- {!! $carga->obraEstruturada() !!}<br>
						@endforeach
					</span>
				</strong>
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;">
		<tr>
			<td style="width:90px">Destinatário:</td>
			<td style="width:560px">
				<strong>
					({{ $carga->destinatarioFisico->autoridade->tipo->tipo }}) 
					{{ $carga->destinatarioFisico->autoridade->nome }}
				</strong>
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;">
		<tr>
			<td style="width:90px">Endereço:</td>
			<td style="width:560px">
				<strong>
					@if ($carga->destinatarioFisico->predio->predio)
						{{ $carga->destinatarioFisico->predio->predio }}<br>
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
						({{ $carga->destinatarioFisico->complemento }})
					@endif
				</strong>
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;">
		<tr>
			<td style="width:90px">Cidade:<br></td>
			<td style="width:510px">
				<strong>
					@if($carga->destinatarioFisico->predio->cidade)
						{{ $carga->destinatarioFisico->predio->cidade }}
					@endif
				</strong>
			</td>
			<td style="border:1px solid black;border-collapse:collapse;width:50px">Estado<br>
				<strong>
					@if($carga->destinatarioFisico->predio->estado)
						{{ $carga->destinatarioFisico->predio->estado }}
					@endif
					</strong>
			</td>
		</tr>
	</table>

	<table style="border:1px solid black;border-collapse:collapse;">
		<tr style="text-align:center;">
			<td style="width:325px">
				RECEBIMENTO<br>
				<br>
				_____ / _____ / __________
			</td>
			<td style="border: 1px solid black;border-collapse: collapse;width:325px;">
				ASSINATURA OU CARIMBO<br><br><br>
			</td>
		</tr>
	</table>

	<table style="border: 0px;">
		<tr>
			<td style="text-align:left">
				{{ $cargas[0]->carga }}
			</td>
			<td style="text-align:right">
				&nbsp;
			</td>
		</tr>
	</table>

@else
	<table style="border:0px">
		<tr>
			<td style="text-align:center">
				<strong>EMPRÉSTIMO DE OBRAS</strong>
			</td>
		</tr>
	</table>
	<table style="border:1px solid black;border-collapse:collapse;text-align:justify">
		<tr>
			<td style="width:90px">Autoridade:</td>
			<td style="width:560px"><strong>{{ $cargas[0]->autoridade->nome }}</strong></td>
		</tr>
	</table>
	<table style="border:1px solid black;border-collapse:collapse;text-align:justify">
		<tr>
			<td style="width:90px">Data:</td>
			<td style="width:560px">{{ $cargas[0]->data_carga->format('d\/m\/Y') }}</td>
		</tr>
		<tr>
			<td style="width:90px">Carga:</td>
			<td style="width:560px"><strong>{{ $cargas[0]->carga }}</strong></td>
		</tr>
		<tr>
			<td style="width:90px">Tipo:</td>
			<td style="width:560px"><strong>{{ $cargas[0]->destinatario->destinatario }}</strong></td>
		</tr>
		<tr>
			<td style="width:90px">Obras:</td>
			<td style="width:560px">
				<strong>
					@foreach ($cargas as $carga)
						- {!! $carga->obraEstruturada() !!}<br>
					@endforeach
				</strong>
			</td>
		</tr>
	</table>
	<br />
@endif

</body>
</html>
