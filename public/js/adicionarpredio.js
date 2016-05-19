$(document).ready(function() {

	// Adicionar endereco
	$('#adicionar').on('click', function()
	{
		var id = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		for (var i=0; i< 5; i++)
			id += possible.charAt(Math.floor(Math.random() * possible.length));
		var divInicio = '<div id="predio" class="form-group">';
		var abreLinha = '<div class="form-group">';
		var fechaLinha = '</div>';
		var predio = '<label for="predio" class="col-sm-2 control-label">Prédio</label><div id="endereco[' + id + ']" class="col-sm-9"><input class="typeahead' + id + ' form-control" placeholder="Prédio" name="predio[' + id + ']" type="text" value=""></div><input id="predio_id' + id + '" name="predio_id[' + id + ']" type="hidden" value="">';
		var sala = '<label for="sala" class="col-sm-2 control-label">Sala ou Gabinete</label><div class="col-sm-3"><input id="sala" class="form-control" placeholder="Sala/Gabinete" name="sala[' + id + ']" type="text" value=""></div>';
		var complemento = '<label for="complemento" class="col-sm-2 control-label">Complemento</label><div class="col-sm-4"><input id="complemento" class="form-control" placeholder="Complemento" name="complemento[' + id + ']" type="text"></div>';
		var botaoRemover = '<div class="col-sm-1"><button id="remover" type="button" class="predio btn btn-danger col-sm-12"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>';
		var divFim = '</div>';

		$('#predios').append( divInicio + abreLinha + predio + botaoRemover + fechaLinha + abreLinha + sala + complemento + fechaLinha + divFim);

		var predio = new Bloodhound({
			name: 'predio',
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('predio'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			limit: 10,
			remote: '/predio/api?predio=%QUERY'
		});

		predio.initialize();

		$('.typeahead' + id)
			.typeahead(
			// Options
			{
				hint: true,
				highlight: true,
				minLength: 3
			},
			// DataSets
			{
				name: 'predio',
				displayKey: 'predio',
				source: predio.ttAdapter(),
				templates: {
					empty: [
						'<div class="empty-message">',
						'Prédio Inexistente.',
						'</div>'
					].join('\n'),
					suggestion: Handlebars.compile('<p><strong>{{predio}}</strong> {{endereco}}</p>')
					}
			})

			// Modificações Externas
			.on('typeahead:selected typeahead:autocompleted', function(e,datum) 
			{
				// Define o ID da predio
				$('#predio_id' + id + '').val(datum.id);
			})
			.on('change typeahead:selected typeahead:autocompleted', function(e,datum) 
			{
				if ($(this).val().length < 1)
				{
					$('#predio_id' + id + '').val('');
				}
			});

	});

});