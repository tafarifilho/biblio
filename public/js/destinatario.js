$(document).on('change', '#destinatario', function()
{
	if ($('#destinatario').val() == 4)
	{
		values = '<div class="form-group">';
		values = values + '<label for="outro_destinatario" class="col-sm-2 control-label">Outro Destinatário</label>';
		values = values + '<div id="outro_destinatario" class="col-sm-10">';
		values = values + '<input id="outro_destinatario" class="typeahead form-control" placeholder="O Outro Destinatário" name="outro_destinatario" type="text">';
		values = values + '</div>';
		values = values + '<input id="outro_destinatario_id" name="outro_destinatario_id" type="hidden">';
		values = values + '</div>';
		values = values + '<div id="outro_destinatario_endereco" class="form-group">';
		values = values + '</div>';

		$('#outrodestinatario').append(values);

		// Typeahead - Outro Destintario

		var autoridade = new Bloodhound({
			name: 'autoridade',
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nome'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			remote: '/autoridade/api?nome=%QUERY'
		});

		autoridade.initialize();

		$('#outro_destinatario .typeahead')
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
						'Outra Autoridade Inexistente.',
						'</div>'
					].join('\n'),
					suggestion: Handlebars.compile('<p><strong>{{nome}}</strong> ({{tipo}})</p>')
					}
			})

			// Modificações Externas
			.on('typeahead:selected typeahead:autocompleted', function(e,datum) 
			{ 
				// Define o ID da autoridade
				$('#outro_destinatario_id').val(datum.id).prop('readonly', true);

				// Cria o menu de endereço, caso se tenha mais que um valor
				if (datum.endereco.length > 1)
				{
					$('#outro_destinatario_endereco').empty('');

					var radioinput = '';

					datum.endereco.forEach(function(data){
						value = data.predio;
						if (data.sala)
							value = value + ', ' + data.sala;
						if (data.complemento)
							value = value + ', ' + data.complemento;

						radioinput = radioinput + '<div class="input-group"><span class="input-group-addon"><input type="radio" id="destinatario_enderecos" name="destinatario_enderecos" value="' + data.id + '" aria-label="destinatario_enderecos"></span><input type="text" class="form-control" aria-label="destinatario_enderecos" value="' + value + '" disabled></div>';

					});

					$('#outro_destinatario_endereco').append('<label for="destinatario_enderecos" class="col-sm-2 control-label">Endereços</label><div id="destinatario_enderecos" class="col-sm-10">' + radioinput + '</div>');

				}
				// Possui apenas um endereço. Cria um hidden
				else
				{
					$('#outro_destinatario_endereco').empty('');
					$('#outro_destinatario_endereco').append('<input id="enderecos_input" name="destinatario_enderecos" type="hidden" value="' + datum.endereco[0].id + '">');
				}

			})
			.on('change typeahead:selected typeahead:autocompleted', function(e,datum) 
			{
				if ($(this).val().length < 1)
				{
					$('#outro_destinatario_id').val('');
					$('#outro_destinatario_endereco').empty('');
				}
			});

	}
});