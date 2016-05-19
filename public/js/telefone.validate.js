var maskBehavior = function (val) {
	if (val.replace(/\D/g, '').length === 11)
		var mascara = '(00) 00000-0000';
	else if (val.replace(/\D/g, '').length === 12)
		var mascara = '(00) 0000-00009';
	else
		var mascara = '(00) 0000-00009 ? R:99999';
	return mascara;
},
options = {onKeyPress: function(val, e, field, options) {
		field.mask(maskBehavior.apply({}, arguments), options);
	}
};

$('#telefone').mask(maskBehavior, options);