'use strict';

$('#divSearch').formValidation(objectValidate(
{
	txtSearch:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Sólo se permite texto y números.</b>',
				regexp: /^[a-zA-Z0-9ñÑàèìòùÀÈÌÒÙáéíóúÁÉÍÓÚ\s@\.\-_]*$/
			}
		}
	}
}));

function searchUser(text, url, event)
{
	var evt=event || window.event;

	var code=evt.charCode || evt.keyCode || evt.which;

	if(code==13)
	{
		var isValid=null;

		$('#divSearch').data('formValidation').resetForm();
		$('#divSearch').data('formValidation').validate();

		isValid=$('#divSearch').data('formValidation').isValid();

		if(!isValid)
		{
			incorrectNote();

			return;
		}

		$('#modalLoading').modal('show');

		$('#txtSearch').attr('disabled', 'disabled');

		window.location.href=url+'?searchParameter='+text;
	}
}

function deleteUserConfirm(idUser, fullName)
{
	if (confirm("¿Está seguro de eliminar al usuario: " + fullName + "?\n\nEsta acción no se puede deshacer y solo es posible si el usuario no tiene registros de agua.")) {
		window.location.href = window.location.origin + '/user/delete/' + idUser;
	}
}