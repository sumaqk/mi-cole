'use strict';

$('#frmInsertUserFromLoginModal').formValidation(objectValidate(
{
	txtFirstNameRegisterLayout:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtSurNameRegisterLayout:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtEmailRegisterLayout:
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
	passPasswordRegisterLayout:
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
				field: 'passPasswordRegisterLayoutRepeat'
			}
		}
	},
	passPasswordRegisterLayoutRepeat:
	{
		validators:
		{
			identical:
			{
				message: '<b style="color: red;">Este campo no coincide con su confirmación correspondiente.</b>',
				field: 'passPasswordRegisterLayout'
			}
		}
	}
}));

$('#frmLogIn').formValidation(objectValidate(
{
	txtEmailLogInLayout:
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
	passPasswordLogInLayout:
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

function readAllNotificationGeneral()
{
	ajaxJson({ _token: _token }, _urlBase+'/usernotification/readall', 'POST', null, function(objectJson)
	{
		if(objectJson.mo.type!='success')
		{
			objectJson.mo.listMessage.forEach(function(element)
			{
				errorNote('No se pudo proceder!', element);
			});

			return false;
		}

		correctNote();

		$('#etiquetaNewNotify').hide();
		$('.ulNotificationGeneralAlert').remove();
	}, false, true);
}

$('#ulNotificationGeneral').on('scroll', function(event)
{
	if(($('#ulNotificationGeneral')[0].scrollTop+30+$('#ulNotificationGeneral').height())>=$('#ulNotificationGeneral')[0].scrollHeight && !($('#tagLoadingAdd').length))
	{
		var idUserNotification=$('#ulNotificationGeneral > li')[$('#ulNotificationGeneral > li').length-1].id;

		if(idUserNotification=='tagLoadingAdd')
		{
			return false;
		}
		
		idUserNotification=idUserNotification.substring(21, idUserNotification.length);

		ajaxJson({ _token: _token, idUserNotification: idUserNotification }, _urlBase+'/usernotification/seebyscroll', 'POST', function()
		{
			if(!$('#ulNotificationGeneral > #liNotificationGeneralLoadingTemp').length)
			{
				$('#ulNotificationGeneral').append('<li id="liNotificationGeneralLoadingTemp" class="opacityTemp" style="background-color: #f5f5f5;color: #999999;padding: 4px;text-align: center;">Cargando...</li>');
			}
		},
		function(objectJson)
		{
			$('#ulNotificationGeneral > #liNotificationGeneralLoadingTemp').remove();

			if(objectJson.mo.type=='success')
			{
				objectJson.mo.listMessage.forEach(function(element)
				{
					errorNote('No se pudo proceder!', element);
				});

				return false;
			}

			var htmlTemp='';

			objectJson.listDto.forEach(function(element)
			{
				if($('#ulNotificationGeneral > #liNotificationGeneral'+element.idUserNotification).length)
				{
					return true;
				}

				htmlTemp+=`<li id="liNotificationGeneral`+element.idUserNotification+`" style="padding-bottom: 0px;padding-top: 0px;position: relative;" class="hoverNotify">
					<a href="`+_urlBase+`/usernotification/read/`+element.idUserNotification+`" style="display: block;height: 100%;padding-bottom: 4px;padding-top: 4px;">
						<div class="wordWrap" style="max-width: 200px;">`;

				if(!element.status)
				{
					htmlTemp+=`<div class="opacityTemp displayInLineBlock" style="background-color: #f39c12;border-radius: 20px;height: 7px;margin-left: 0px;position: absolute;right: 2px;top: 2px;width: 7px;"></div>`;
				}

				htmlTemp+=element.description.viiInjectionEscape()+`
						</div>
					</a>
				</li>`;
			});

			$('#ulNotificationGeneral').append(htmlTemp);
		}, false, true);
	}
});

function sendFrmInsertUserFromLoginModal()
{
	var isValid=null;

	$('#frmInsertUserFromLoginModal').data('formValidation').resetForm();
	$('#frmInsertUserFromLoginModal').data('formValidation').validate();

	isValid=$('#frmInsertUserFromLoginModal').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmInsertUserFromLoginModal');
}

function sendFrmLogIn()
{
	if($('#modalLoading').is(':visible'))
	{
		return;
	}

	var isValid=null;

	$('#frmLogIn').data('formValidation').resetForm();
	$('#frmLogIn').data('formValidation').validate();

	isValid=$('#frmLogIn').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	$('#modalLoading').modal('show');

	$('#frmLogIn')[0].submit();
}