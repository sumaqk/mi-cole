'use strict';

$('#frmEditUser').formValidation(objectValidate(
{
	txtFirstName:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtSurName:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	}
}));

$('#frmChangePasswordUser').formValidation(objectValidate(
{
	passPassword:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	passPasswordNew:
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
				field: 'passPasswordNewRepeat'
			}
		}
	},
	passPasswordNewRepeat:
	{
		validators:
		{
			identical:
			{
				message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
				field: 'passPasswordNew'
			}
		}
	}
}));

$('#frmChangeEmailUser').formValidation(objectValidate(
{
	txtEmailForChangeEmail:
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
	txtEmailChangeCodeForChangeEmail:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	passPasswordForChangeEmail:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	}
}));

function getEmailChangeCode()
{
	var isValid=null;

	$('#frmChangeEmailUser').data('formValidation').validateField('txtEmailForChangeEmail');

	isValid=$('#frmChangeEmailUser').data('formValidation').isValidField('txtEmailForChangeEmail');

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	ajaxJson({ _token: _token, email: $('#txtEmailForChangeEmail').val() }, _urlBase+'/user/getemailchangecode', 'POST', null, function(objectJson)
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

			$('#txtEmailForChangeEmail').attr('readonly', 'readonly');
			$('#txtEmailForChangeEmail').parent().addClass('readonly', 'readonly');

			htmlTemp=`<div class="alert alert-info alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				`+objectJson.mo.listMessage[0].viiInjectionEscape()+`
			</div>`;
		}
		else
		{
			errorNote('Error!', 'El correo ingresado ya se encuentra registrado en la plataforma.');

			htmlTemp=`<div class="alert alert-danger alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				`+objectJson.mo.listMessage[0].viiInjectionEscape()+`
			</div>`;
		}

		$('#divSendMessageResponse > div').html(htmlTemp);
		$('#divSendMessageResponse').show();
	}, false, true);
}

function sendFrmChangeEmailUser()
{
	var isValid=null;

	$('#frmChangeEmailUser').data('formValidation').resetForm();
	$('#frmChangeEmailUser').data('formValidation').validate();

	isValid=$('#frmChangeEmailUser').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmChangeEmailUser');
}

function sendFrmEditUser()
{
	var isValid=null;

	$('#frmEditUser').data('formValidation').resetForm();
	$('#frmEditUser').data('formValidation').validate();

	isValid=$('#frmEditUser').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmEditUser');
}

function sendFrmUploadAvatar()
{
	if($('#fileAvatar').val()==null || $('#fileAvatar').val()=='')
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmUploadAvatar');
}

function sendFrmChangePasswordUser()
{
	var isValid=null;

	$('#frmChangePasswordUser').data('formValidation').resetForm();
	$('#frmChangePasswordUser').data('formValidation').validate();

	isValid=$('#frmChangePasswordUser').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmChangePasswordUser');
}