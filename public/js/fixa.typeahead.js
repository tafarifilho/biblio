$(document).ready(function() {

	// Typeahead - Localização Fixa

	var fixa = new Bloodhound({
		name: 'fixa',
		datumTokenizer: Bloodhound.tokenizers.obj.whitespace('fixa'),
		queryTokenizer: Bloodhound.tokenizers.whitespace,
		limit: 10,
		remote: '/obra/api?fixa=%QUERY'
	});

	fixa.initialize();

	$('#fixa .typeahead')
		.typeahead(
		{
			hint: true,
			highlight: true,
			minLength: 6
		},
		{
			name: 'fixa',
			displayKey: 'localizacao',
			source: fixa.ttAdapter(),
			templates: {
				empty: [
					'<div class="empty-message">',
					'Localização Inexistente.',
					'</div>'
				].join('\n'),
				suggestion: Handlebars.compile('<p><strong>{{localizacao}}</strong> ({{autor}}. {{titulo}})</p>')
				}
		})
		.on('typeahead:selected typeahead:autocompleted', function(e,datum) 
		{ 
			// Define o valor do tombo e desabilita
			if (datum.tombo)
				$('#tombo_conf').val(datum.tombo).prop('readonly', true);
			else
				$('#tombo_conf').prop('readonly', true);

			// Define o valor do título e desabilita
			$('#titulo').val(datum.titulo).prop('readonly', true);

			// Verifica a existencia de autor, define e desabilita
			if (datum.autor)
				$('#autor').val(datum.autor).prop('readonly', true);
			else
				$('#autor').prop('readonly', true);

			// Classificação
			if (datum.classificacao)
				$('#classificacao').val(datum.classificacao).prop('readonly', true);
			else
				$('#classificacao').prop('readonly', true);

			// Notação
			if (datum.notacao)
				$('#notacao').val(datum.notacao).prop('readonly', true);
			else
				$('#notacao').prop('readonly', true);

			// Verifica a existência de volume, define e desabilita
			if (datum.volume)
				$('#volume').val(datum.volume).prop('readonly', true);
			else
				$('#volume').prop('readonly', true);

			// Verifica a existência de edicao, define e desabilita
			if (datum.edicao)
				$('#edicao').val(datum.edicao).prop('readonly', true);
			else
				$('#edicao').prop('readonly', true);

			// Verifica a existência de ano, define e desabilita
			if (datum.ano)
				$('#ano').val(datum.ano).prop('readonly', true);
			else
				$('#ano').prop('readonly', true);

			// Conjunto Suplementar
			if (datum.cs)
				$('#cs').val(datum.cs).prop('readonly', true);
			else
				$('#cs').prop('readonly', true);

			// Estante
			if (datum.estante)
				$('#estante').val(datum.estante).prop('readonly', true);
			else
				$('#estante').prop('readonly', true);

			// Prateleira
			if (datum.prateleira)
				$('#prateleira').val(datum.prateleira).prop('readonly', true);
			else
				$('#prateleira').prop('readonly', true);

			// Número
			if (datum.numero)
				$('#numero').val(datum.numero).prop('readonly', true);
			else
				$('#numero').prop('readonly', true);

			// Dígito
			if (datum.cs)
				$('#digito').val(datum.digito).prop('readonly', true);
			else
				$('#digito').prop('readonly', true);

			// ID da Obra
			$('#obra_id').append('<input id="obra_tmp" name="obra_tmp" type="hidden" value="' + datum.id + '">');

		})
		.on('change typeahead:selected typeahead:autocompleted', function(e,datum) 
		{
			if ($(this).val().length < 1)
			{
				$('#obra_id')      .empty();
				$('#tombo_conf')   .val('').prop('readonly', false);
				$('#titulo')       .val('').prop('readonly', false);
				$('#autor')        .val('').prop('readonly', false);
				$('#classificacao').val('').prop('readonly', false);
				$('#notacao')      .val('').prop('readonly', false);
				$('#volume')       .val('').prop('readonly', false);
				$('#edicao')       .val('').prop('readonly', false);
				$('#ano')          .val('').prop('readonly', false);
				$('#cs')           .val('').prop('readonly', false);
				$('#estante')      .val('').prop('readonly', false);
				$('#prateleira')   .val('').prop('readonly', false);
				$('#numero')       .val('').prop('readonly', false);
				$('#digito')       .val('').prop('readonly', false);
			}
			
		});

});