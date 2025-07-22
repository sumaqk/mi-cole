'use strict';

$('#frmEditUserAsAdmin').formValidation(objectValidate(
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
	}
}));

function sendFrmEditUserAsAdmin()
{
	var isValid=null;

	$('#frmEditUserAsAdmin').data('formValidation').resetForm();
	$('#frmEditUserAsAdmin').data('formValidation').validate();

	isValid=$('#frmEditUserAsAdmin').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmEditUserAsAdmin');
}