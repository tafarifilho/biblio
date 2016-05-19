$(document).ready(function() {

	// Adicionar telefone
	$('#adicionar').on('click', function()
	{
		var id = "";
		var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		for (var i=0; i< 5; i++)
			id += possible.charAt(Math.floor(Math.random() * possible.length));
		var divInicio = '<div id="telefone" class="form-group">';
		var telefone = '<label for="telefones[]" class="col-sm-2 control-label">Telefone</label><div class="col-sm-4"><input class="form-control" placeholder="Telefone" name="telefones[' + id + ']" type="tel" autocomplete="off"></div>';
		var tipo_telefone = '<label for="tipos_telefones[]" class="col-sm-2 control-label">Tipo</label><div class="col-sm-3"><input class="form-control" placeholder="Tipo" name="tipos_telefones[' + id + ']" type="tel"></div>';
		var botaoRemover = '<div class="col-sm-1"><button id="adicionar" type="button" class="telefone btn btn-danger col-sm-12"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button></div>';
		var divFim = '</div>';

		$('#telefones').append( divInicio + telefone + tipo_telefone + botaoRemover + divFim);
	});

});