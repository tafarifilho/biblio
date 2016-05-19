$(document).ready(function() {

	var predio = new Bloodhound({
		name: 'predio',
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('predio'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: '/predio/api?predio=%QUERY'
	});

	predio.initialize();

	$('#predio .typeahead')
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
			$('#predio_id').val(datum.id).prop('readonly', true);
		})
		.on('change typeahead:selected typeahead:autocompleted', function(e,datum) 
		{
			if ($(this).val().length < 1)
			{
				$('#predio_id').val('');
			}
		});

});