$(document).ready(function() {

	// Typeahead - Autoridade

	var autoridade = new Bloodhound({
		name: 'autoridade',
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nome'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: '/autoridade/api?nome=%QUERY'
	});

	autoridade.initialize();

	$('#autoridade .typeahead')
		.typeahead(
		// Options
		{
			hint: true,
			highlight: true,
			minLength: 4
		},
		// DataSets
		{
			name: 'autoridade',
			displayKey: 'nome',
			source: autoridade.ttAdapter(),
			templates: {
				empty: [
					'<div class="empty-message">',
					'Autoridade Inexistente.',
					'</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<p><strong>{{nome}}</strong> ({{tipo}})</p>')
				}
		})

		// Modificações Externas
		.on('typeahead:selected typeahead:autocompleted', function(e,datum) 
		{ 
			// Define o ID da autoridade
			$('#autoridade_id').val(datum.id).prop('readonly', true);

			// Cria o menu de endereço, caso se tenha mais que um valor
			if (datum.endereco.length > 1)
			{
				$('#enderecos').empty('');

				var radioinput = '';

				datum.endereco.forEach(function(data){
					value = data.predio;
					if (data.sala)
						value = value + ', ' + data.sala;
					if (data.complemento)
						value = value + ', ' + data.complemento;

					radioinput = radioinput + '<div class="input-group"><span class="input-group-addon"><input type="radio" id="enderecos" name="enderecos" value="' + data.id + '" aria-label="enderecos"></span><input type="text" class="form-control" aria-label="enderecos" value="' + value + '" disabled></div>';

				});

				$('#enderecos').append('<label for="enderecos" class="col-sm-2 control-label">Endereços</label><div id="enderecos" class="col-sm-10">' + radioinput + '</div>');

			}
			// Possui apenas um endereço. Cria um hidden
			else
			{
				$('#enderecos').empty('');
				$('#enderecos').append('<input id="enderecos_input" name="enderecos" type="hidden" value="' + datum.endereco[0].id + '">');
			}

			// Exibe a quantidade de cargas em aberto
			if (datum.cargas.length > 0)
			{

				$('#cargas').empty('');

				var alertacargas = '<strong>Cargas em Aberto: ' + datum.cargas.length + '</strong><br />';

				datum.cargas.forEach(function(data){
					value = data.data_carga;
					if (data.nome)
				 		value = value + ' ' + data.nome;
				 	if (data.titulo)
				 		value = value + '. ' + data.titulo;

				 	alertacargas = alertacargas + value + '.<br />';
				});
				 $('#cargas').append('<div class="alert alert-info" role="alert"' + alertacargas + '</div>');
			}
			else
			{
				$('#cargas').empty('');
			}

		})
		.on('change typeahead:selected typeahead:autocompleted', function(e,datum) 
		{
			if ($(this).val().length < 1)
			{
				$('#autoridade_id').val('');
				$('#enderecos').empty('');
				$('#cargas').empty('');
			}
		});

});