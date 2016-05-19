$(document).on('click', '#realizar', function()
	{
		// ( Endereço Único OU Radio escolhido ) E Id Autoridade E Destinatário E Solicitante
		if ( ( $('#enderecos_input').val() || $('#enderecos:checked').length > 0 ) &&  $('#autoridade_id').val() && $('#obras_input').val() && $('#destinatario').val() && $('#solicitante').val() && $('#tipo_solicitacao').val())
		{
			// Continua o submit
			return true;
		}
		else
		{
			if (!$('#autoridade_id').val())
				$('#autoridade').closest('.form-group').addClass('has-error');
			else
			{
				$('#autoridade').closest('.form-group').removeClass('has-error');
				$('#autoridade').closest('.form-group').addClass('has-success');
			}

			if (!$('#obras_input').val())
			{
				$('#panelstyle').removeClass('panel-success');
				$('#panelstyle').addClass('panel-danger');
			}
			else
			{
				$('#panelstyle').removeClass('panel-danger');
				$('#panelstyle').addClass('panel-success');
			}

			if (!$('#destinatario').val())
				$('#destinatario').closest('.form-group').addClass('has-error');
			else
			{
				$('#destinatario').closest('.form-group').removeClass('has-error');
				$('#destinatario').closest('.form-group').addClass('has-success');
			}

			if (!$('#solicitante').val())
				$('#solicitante').closest('.form-group').addClass('has-error');
			else
			{
				$('#solicitante').closest('.form-group').removeClass('has-error');
				$('#solicitante').closest('.form-group').addClass('has-success');
			}

			if (!$('#tipo_solicitacao').val())
				$('#tipo_solicitacao').closest('.form-group').addClass('has-error');
			else
			{
				$('#tipo_solicitacao').closest('.form-group').removeClass('has-error');
				$('#tipo_solicitacao').closest('.form-group').addClass('has-success');
			}

			return false;
		}
				
	});
