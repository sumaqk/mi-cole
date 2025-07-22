'use strict';

$('#ulGeneralNotification').on('scroll', function(event)
{
	if(($('#ulGeneralNotification')[0].scrollTop+30+$('#ulGeneralNotification').height())>=$('#ulGeneralNotification')[0].scrollHeight && !($('#tagLoadingAdd').length))
	{
		var idUserNotification=$($('#ulGeneralNotification > li')[$('#ulGeneralNotification > li').length-1]).attr('id');

		if(idUserNotification=='tagLoadingAdd' || idUserNotification=='liGeneralNotification0000000000000')
		{
			return false;
		}
		
		idUserNotification=idUserNotification.substring(21, idUserNotification.length);

		ajaxScrollDown('ulGeneralNotification', { _token: _token, idUserNotification: idUserNotification }, _urlBase+'/usernotification/seebyscroll', 'POST', null, null, false, true, 'li');
	}
});

function readAllGeneralNotification()
{
	ajaxJson({ _token: _token }, _urlBase+'/usernotification/readall', 'POST', null, function(objectJson)
	{
		switch(objectJson.mo.type)
		{
			case 'exception':
				objectJson.mo.listMessage.forEach(function(element)
				{
					errorNote('Excepción ocurrida!', element);
				});

			break;

			case 'error':
				objectJson.mo.listMessage.forEach(function(element)
				{
					errorNote('No se pudo proceder', element);
				});

			break;

			case 'success':
				correctNote();

				$('#labelNewGeneralNotification').text(null);
				$('.labelAlertNewGeneralNotification').remove();

			break;
		}
	}, false, true);
}

function permanentVerificationGeneralNotification()
{
	window.setTimeout(() =>
	{
		var idUserNotification=$('#ulGeneralNotification > li').first();

		idUserNotification=idUserNotification.length!=0 ? $(idUserNotification).attr('id').substring(21, $(idUserNotification).attr('id').length) : null;

		$.ajax(
		{
			url: _urlBase+'/usernotification/verify',
			type: 'post',
			data: { _token: _token, idUserNotification: idUserNotification },
			cache: false,
			async: true
		}).done(function(page)
		{
			$('#ulGeneralNotification').prepend(page);
		}).fail(function(){});

		permanentVerificationGeneralNotification();
	}, 10000);
}

// permanentVerificationGeneralNotification();