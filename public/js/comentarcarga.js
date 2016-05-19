$('#comentarModal').on('show.bs.modal', function (e)
	{
		if ($('#eventsTable').bootstrapTable('getSelections').length > 0)
			// Abre o Modal
			return true;
		else
			return false;
	});

$(document).on('click', '#comentarCarga', function()
	{
		if ( $('#contato').val() && $('#observacao').val() )
		{
			// Continua o submit
			return true;
		}
		else
		{
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