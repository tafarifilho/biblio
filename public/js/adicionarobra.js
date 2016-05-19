$(document).ready(function() {

	// Adicionar obra e limpar campos
	$('#adicionar').on('click', function()
	{
		var linha = '';
		if ( $('#tombo_conf').val() )
			linha = '(' + $('#tombo_conf').val() + ') ';
		if ( $('#autor').val() )
			linha = linha + $('#autor').val() + '. ';
		linha = linha + $('#titulo').val();
		if ( $('#volume').val() )
			linha = linha + '. ' + $('#volume').val();
		if ( $('#edicao').val() )
			linha = linha + '. ' + $('#edicao').val();
		if ( $('#ano').val() )
			linha = linha + ' ' + $('#ano').val();

		// Problema de obras que não estão no sistema
		if ($('#obra_tmp').val())
		{
			valor = $('#obra_tmp').val()
		}
		else
		{
			obj = {
				'tombo'         : $('#tombo_conf').val(),
				'titulo'        : $('#titulo').val(),
				'autor'         : $('#autor').val(),
				'classificacao' : $('#classificacao').val(),
				'notacao'       : $('#notacao').val(),
				'volume'        : $('#volume').val(),
				'edicao'        : $('#edicao').val(),
				'ano'           : $('#ano').val(),
				'cs'            : $('#cs').val(),
				'estante'       : $('#estante').val(),
				'prateleira'    : $('#prateleira').val(),
				'numero'        : $('#numero').val(),
				'digito'        : $('#digito').val(),
			};

			//valor = JSON.stringify(obj);
			valor = jQuery.param(obj);
		}

		var obra = '<li class="obra list-group-item">' + linha + '<span class="pull-right"><button type="button" class="remover btn btn-danger btn-xs" aria-label="Left Align"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></span><input id="obras_input" name="obras[]" type="hidden" value="' + valor + '"></li>';

		$('#painel').append( obra );

		// Apagar os campos após criar a nova linha da obra
		$('#tombo .typeahead').val('');
		$('#fixa .typeahead').val('');

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

	});

});



