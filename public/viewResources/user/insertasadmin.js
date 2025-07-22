'use strict';

var editorTemp=null;

$('#frmInsertAsAdminUser').formValidation(objectValidate(
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
	},
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
				field: 'passRetypePassword'
			}
		}
	},
	passRetypePassword:
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

function sendFrmInsertAsAdminUser()
{
	var isValid=null;

	$('#frmInsertAsAdminUser').data('formValidation').resetForm();
	$('#frmInsertAsAdminUser').data('formValidation').validate();

	isValid=$('#frmInsertAsAdminUser').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmInsertAsAdminUser');
}