'use strict';

$('#frmManagementConfiguration').formValidation(objectValidate(
{
	fileBlackLogo:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg o jpeg" y no más de 100KB.</b>',
				extension: 'png,jpg,jpeg',
				maxSize: 102400
			}
		}
	},
	fileBlackLogoMinimal:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg o jpeg" y no más de 100KB.</b>',
				extension: 'png,jpg,jpeg',
				maxSize: 102400
			}
		}
	},
	fileWhiteLogo:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg o jpeg" y no más de 100KB.</b>',
				extension: 'png,jpg,jpeg',
				maxSize: 102400
			}
		}
	},
	fileWhiteLogoMinimal:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg o jpeg" y no más de 100KB.</b>',
				extension: 'png,jpg,jpeg',
				maxSize: 102400
			}
		}
	},
	txtLinkedInUrl:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://linkedin.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtFacebookUrl:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://facebook.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtYouTubeUrl:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://youtube.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtTwitterUrl:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://twitter.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtTextForPhone:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtPhone:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtPhoneContact:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtTextForAddress:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtAddress:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtFullAddress:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtLatitudeMap:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message : '<b style="color: red;">Formato incorrecto [Ejemplo: -72.8869927].</b>',
				regexp : /^((\-)?[0-9]{1,3}\.[0-9]{2,15})?$/
			}
		}
	},
	txtLongitudeMap:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message : '<b style="color: red;">Formato incorrecto [Ejemplo: -72.8869927].</b>',
				regexp : /^((\-)?[0-9]{1,3}\.[0-9]{2,15})?$/
			}
		}
	},
	txtZoomMap:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message : '<b style="color: red;">Formato incorrecto [Ejemplo: 15].</b>',
				regexp : /^([1-9]{1}[0-9]*)?$/
			}
		}
	},
	txtTextForDateText:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtDateText:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtContactEmail:
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
				regexp: /^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/
			}
		}
	},
	txtFooterYear:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message : '<b style="color: red;">Formato incorrecto [Ejemplo: 2020].</b>',
				regexp : /^(20[0-9]{2})?$/
			}
		}
	},
	txtFooterText:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtFooterUrl:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://codideep.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtUrlForEmail:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			},
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://codideep.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	txtTwoDescriptionBannerOne:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtHtmlCentralDescriptionBannerOne:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtUrlBannerOne:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://codideep.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	fileBackgroundBannerOne:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg, jpeg o gif" y no más de 700KB.</b>',
				extension: 'png,jpg,jpeg,gif',
				maxSize: 716800
			}
		}
	},
	txtTwoDescriptionBannerTwo:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtHtmlCentralDescriptionBannerTwo:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtUrlBannerTwo:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://codideep.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	fileBackgroundBannerTwo:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg, jpeg o gif" y no más de 700KB.</b>',
				extension: 'png,jpg,jpeg,gif',
				maxSize: 716800
			}
		}
	},
	txtTwoDescriptionBannerThree:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtHtmlCentralDescriptionBannerThree:
	{
		validators:
		{
			notEmpty:
			{
				message: '<b style="color: red;">Este campo es requerido.</b>'
			}
		}
	},
	txtUrlBannerThree:
	{
		validators:
		{
			regexp:
			{
				message: '<b style="color: red;">Formato incorrecto [Ejemplo: https://codideep.com].</b>',
				regexp: /^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i
			}
		}
	},
	fileBackgroundBannerThree:
	{
		validators:
		{
			file:
			{
				message: '<b style="color: red;">Sólo se permite formato "png, jpg, jpeg o gif" y no más de 700KB.</b>',
				extension: 'png,jpg,jpeg,gif',
				maxSize: 716800
			}
		}
	}
}));

function sendFrmManagementConfiguration()
{
	var isValid=null;

	$('#frmManagementConfiguration').data('formValidation').resetForm();
	$('#frmManagementConfiguration').data('formValidation').validate();

	isValid=$('#frmManagementConfiguration').data('formValidation').isValid();

	if(!isValid)
	{
		incorrectNote();

		return;
	}

	confirmDialogSend('frmManagementConfiguration');
}