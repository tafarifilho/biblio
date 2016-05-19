$('#renovarModal').on('show.bs.modal', function (e)
	{
		if ($('#eventsTable').bootstrapTable('getSelections').length > 0)
			// Abre o Modal
			return true;
		else
			return false;
	});

$(document).on('click', '#renovarCarga', function()
	{
		if ( $('#contato').val() && $('#observacao').val() && ( $('#prazo').val() || $('#excepcional').val() ) )
		{
			// Continua o submit
			return true;
		}
		else
		{
			if (!$('#prazo').val() && !$('#excepcional').val())
			{
				$('#prazo').closest('.form-group').addClass('has-error');
				$('#excepcional').closest('.form-group').addClass('has-error');
			}
			else if ($('#prazo').val() && $('#excepcional').val())
			{
				$('#prazo').val('').prop('readonly', true);
				$('#excepcional').closest('.form-group').removeClass('has-error');
				$('#excepcional').closest('.form-group').addClass('has-success');
				$('#prazo').closest('.form-group').removeClass('has-success');
				$('#prazo').closest('.form-group').removeClass('has-error');

			}
			else
			{
				if ($('#prazo').val() && !$('#excepcional').val())
				{
					$('#prazo').closest('.form-group').removeClass('has-error');
					$('#prazo').closest('.form-group').addClass('has-success');
					$('#excepcional').closest('.form-group').removeClass('has-error');
					$('#excepcional').closest('.form-group').removeClass('has-success');
				}
				else if (!$('#prazo').val() && $('#excepcional').val())
				{
					$('#excepcional').closest('.form-group').removeClass('has-error');
					$('#excepcional').closest('.form-group').addClass('has-success');
					$('#prazo').closest('.form-group').removeClass('has-error');
					$('#prazo').closest('.form-group').removeClass('has-success');
				}
			}

			if (!$('#contato').val())
				$('#contato').closest('.form-group').addClass('has-error');
			else
			{
				$('#contato').closest('.form-group').removeClass('has-error');
				$('#contato').closest('.form-group').addClass('has-success');
			}

			if (!$('#observacao').val())
				$('#observacao').closest('.form-group').addClass('has-error');
			else
			{
				$('#observacao').closest('.form-group').removeClass('has-error');
				$('#observacao').closest('.form-group').addClass('has-success');
			}

			return false;
		}
				
	});
