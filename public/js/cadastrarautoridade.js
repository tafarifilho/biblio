$(document).on('click', '#cadastrar', function()
	{

		if ( $('.typeahead').typeahead('val').length == 0 || ( !$('#generoM').is(':checked') && !$('#generoF').is(':checked') ) || !$('#email').val() || !$('#tipo_autoridade_id').val() )
		{

			if ( $('.typeahead').typeahead('val').length == 0 )
			{
				$('#autoridade').closest('.form-group').addClass('has-error');
			}
			else
			{
				$('#autoridade').closest('.form-group').removeClass('has-error');
				$('#autoridade').closest('.form-group').addClass('has-success');
			}

			if (!$('#generoM').is(':checked') && !$('#generoF').is(':checked'))
			{
				$('#genero').closest('.form-group').addClass('has-error');
			}
			else
			{
				$('#genero').closest('.form-group').removeClass('has-error');
				$('#genero').closest('.form-group').addClass('has-success');
			}

			if (!$('#email').val())
			{
				$('#email').closest('.form-group').addClass('has-error');
			}
			else
			{
				$('#email').closest('.form-group').removeClass('has-error');
				$('#email').closest('.form-group').addClass('has-success');
			}

			if (!$('#tipo_autoridade_id').val())
			{
				$('#tipo_autoridade_id').closest('.form-group').addClass('has-error');
			}
			else
			{
				$('#tipo_autoridade_id').closest('.form-group').removeClass('has-error');
				$('#tipo_autoridade_id').closest('.form-group').addClass('has-success');
			}
			return false;
		}

		// Continua o Submit
		else
			return true;
	});
