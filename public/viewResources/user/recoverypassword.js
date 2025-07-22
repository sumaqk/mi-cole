'use strict';

$('#frmUserRecoveryPassword').formValidation(objectValidate(
{
	txtEmail:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto. [Ejemplo: any@gmail.com].</b>',
				regexp: /^[a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?$/
			}
		}
	},
	txtRecoveryCode:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	passPassword:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			identical:
			{
				message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
				field: 'passPasswordRetype'
			}
		}
	},
	passPasswordRetype:
	{
		validators:
		{
			identical:
			{
				message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
				field: 'passPassword'
			}
		}
	}
}));

function getRecoveryCode()
{
	var isValid=null;

	$('#frmUserRecoveryPassword').data('formValidation').validateField('txtEmail');

	isValid=$('#frmUserRecoveryPassword').data('formValidation').isValidField('txtEmail');

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	ajaxJson({ _token: _token, email: $('#txtEmail').val() }, _urlBase+'/user/getrecoverycode', 'POST', null, function(objectJson)
	{
		if(objectJson.mo.type=='exception')
		{
			objectJson.mo.listMessage.forEach(function(element)
			{
				errorNote('Excepción ocurrida!', element);
			});

			return false;
		}

		var htmlTemp=null;

		if(objectJson.mo.type=='success')
		{
			correctNote();

			$('#txtEmail').attr('readonly', 'readonly');
			$('#txtEmail').parent().addClass('readonly', 'readonly');

			htmlTemp=`<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				`+objectJson.mo.listMessage[0].viiInjectionEscape()+`
			</div>`;
		}
		else
		{
			errorNote('Error!', 'El correo ingresado no existe en la plataforma.');

			htmlTemp=`<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				`+objectJson.mo.listMessage[0].viiInjectionEscape()+`
			</div>`;
		}

		$('#divSendMessageResponse > div').html(htmlTemp);
		$('#divSendMessageResponse').show();
	}, false, true);
}

function sendFrmUserRecoveryPassword()
{
	var isValid=null;

	$('#frmUserRecoveryPassword').data('formValidation').resetForm();
	$('#frmUserRecoveryPassword').data('formValidation').validate();

	isValid=$('#frmUserRecoveryPassword').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmUserRecoveryPassword');
}