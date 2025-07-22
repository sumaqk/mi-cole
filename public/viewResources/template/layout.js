'use strict';

console.log('%cCuidado!!! esta consola está restringida para personas específicas, un mal uso implica posible robo de información por parte de quien le haya dicho que ingrese datos aquí.\n\nAtte: Codideep, cuidando tu seguridad.', 'font-size: 16px;color: red;');

var arrayCountry=['Afganist&aacute;n', 'Albania', 'Alemania', 'Andorra', 'Angola', 'Antigua y Barbuda', 'Arabia Saudita', 'Argelia', 'Argentina', 'Armenia', 'Australia', 'Austria', 'Azerbaiy&aacute;n', 'Bahamas', 'Banglad&eacute;s', 'Barbados', 'Bar&eacute;in', 'B&eacute;lgica', 'Belice', 'Ben&iacute;n', 'Bielorrusia', 'Birmania', 'Bolivia', 'Bosnia y Herzegovina', 'Botsuana', 'Brasil', 'Brun&eacute;i', 'Bulgaria', 'Burkina Faso', 'Burundi', 'But&aacute;n', 'Cabo Verde', 'Camboya', 'Camer&uacute;n', 'Canad&aacute;', 'Catar', 'Chad', 'Chile', 'China', 'Chipre', 'Ciudad del Vaticano', 'Colombia', 'Comoras', 'Corea del Norte', 'Corea del Sur', 'Costa de Marfil', 'Costa Rica', 'Croacia', 'Cuba', 'Dinamarca', 'Dominica', 'Ecuador', 'Egipto', 'El Salvador', 'Emiratos &Aacute;rabes Unidos', 'Eritrea', 'Eslovaquia', 'Eslovenia', 'España', 'Estados Unidos', 'Estonia', 'Etiop&iacute;a', 'Filipinas', 'Finlandia', 'Fiyi', 'Francia', 'Gab&oacute;n', 'Gambia', 'Georgia', 'Ghana', 'Granada', 'Grecia', 'Guatemala', 'Guyana', 'Guinea', 'Guinea ecuatorial', 'Guinea-Bis&aacute;u', 'Hait&iacute;', 'Honduras', 'Hungr&iacute;a', 'India', 'Indonesia', 'Irak', 'Ir&aacute;n', 'Irlanda', 'Islandia', 'Islas Marshall', 'Islas Salom&oacute;n', 'Israel', 'Italia', 'Jamaica', 'Jap&oacute;n', 'Jordania', 'Kazajist&aacute;n', 'Kenia', 'Kirguist&aacute;n', 'Kiribati', 'Kuwait', 'Laos', 'Lesoto', 'Letonia', 'L&iacute;bano', 'Liberia', 'Libia', 'Liechtenstein', 'Lituania', 'Luxemburgo', 'Madagascar', 'Malasia', 'Malaui', 'Maldivas', 'Mal&iacute;', 'Malta', 'Marruecos', 'Mauricio', 'Mauritania', 'M&eacute;xico', 'Micronesia', 'Moldavia', 'M&oacute;naco', 'Mongolia', 'Montenegro', 'Mozambique', 'Namibia', 'Nauru', 'Nepal', 'Nicaragua', 'N&iacute;ger', 'Nigeria', 'Noruega', 'Nueva Zelanda', 'Om&aacute;n', 'Otro', 'Pa&iacute;ses Bajos', 'Pakist&aacute;n', 'Palaos', 'Panam&aacute;', 'Pap&uacute;a Nueva Guinea', 'Paraguay', 'Per&uacute;', 'Polonia', 'Portugal', 'Reino Unido', 'Rep&uacute;blica Centroafricana', 'Rep&uacute;blica Checa', 'Rep&uacute;blica de Macedonia', 'Rep&uacute;blica del Congo', 'Rep&uacute;blica Democr&aacute;tica del Congo', 'Rep&uacute;blica Dominicana', 'Rep&uacute;blica Sudafricana', 'Ruanda', 'Ruman&iacute;a', 'Rusia', 'Samoa', 'San Crist&oacute;bal y Nieves', 'San Marino', 'San Vicente y las Granadinas', 'Santa Luc&iacute;a', 'Santo Tom&eacute; y Pr&iacute;ncipe', 'No especificado', 'Senegal', 'Serbia', 'Seychelles', 'Sierra Leona', 'Singapur', 'Siria', 'Somalia', 'Sri Lanka', 'Suazilandia', 'Sud&aacute;n', 'Sud&aacute;n del Sur', 'Suecia', 'Suiza', 'Surinam', 'Tailandia', 'Tanzania', 'Tayikist&aacute;n', 'Timor Oriental', 'Togo', 'Tonga', 'Trinidad y Tobago', 'T&uacute;nez', 'Turkmenist&aacute;n', 'Turqu&iacute;a', 'Tuvalu', 'Ucrania', 'Uganda', 'Uruguay', 'Uzbekist&aacute;n', 'Vanuatu', 'Venezuela', 'Vietnam', 'Yemen', 'Yibuti', 'Zambia', 'Zimbabue'];

$(function()
{
	$('body').keypress(function(event)
	{
		if(event.keyCode===10 || event.keyCode===13)
		{
			event.preventDefault();
		}
	});

	$('[data-toggle="tooltip"]').tooltip();

	$('.select').select2(
	{
		language:
		{
			noResults: function()
			{
				return "No se encontraron resultados.";
			},
			searching: function()
			{
				return "Buscando...";
			},
			inputTooShort: function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		allowClear: true,
		placeholder: 'Buscar...',
		minimumInputLength: 3
	});

	$('.selectStatic').select2(
	{
		language:
		{
			noResults: function()
			{
				return "No se encontraron resultados.";
			},
			searching: function()
			{
				return "Buscando...";
			},
			inputTooShort: function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		allowClear: true,
		placeholder: 'Buscar...'
	});

	$('.selectStaticTag').select2(
	{
		language:
		{
			noResults: function()
			{
				return "No se encontraron resultados.";
			},
			searching: function()
			{
				return "Buscando...";
			},
			inputTooShort: function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		allowClear: true,
		placeholder: 'Buscar...',
		tags: true
	});

	$('.selectStaticNotClear').select2(
	{
		language:
		{
			noResults: function()
			{
				return "No se encontraron resultados.";
			},
			searching: function()
			{
				return "Buscando...";
			},
			inputTooShort: function()
			{ 
				return 'Por favor ingrese 3 o más caracteres';
			}
		},
		placeholder: 'Buscar...'
	});

	$(document).on('focus', '.select2-selection.select2-selection--single', function(e)
	{
		$(this).closest(".select2-container").siblings('select:enabled').select2('open');
	});

	$('select.select2').on('select2:closing', function(e)
	{
		$(e.target).data('select2').$selection.one('focus focusin', function(e)
		{
			e.stopPropagation();
		});
	});

	$('.datePicker').datepicker(
	{
		autoclose: true,
		format: 'dd-mm-yyyy'
	});

	$('.datePickerYear').datepicker(
	{
		autoclose: true,
		format: 'yyyy',
		viewMode: 'years',
		minViewMode: 'years'
	});

	$('.datePickerNextDateNow').datepicker(
	{
		autoclose: true,
		format: 'dd-mm-yyyy',
		startDate: new Date()
	});

	if(localStorage.getItem('collapseMenu') !== null && localStorage.getItem('collapseMenu') === "true")
	{
		$('body').addClass('sidebar-collapse');
	}

	if(isChrome)
	{
		$('input[type=text]').attr('autocomplete', '~!@#$%^&*()_+');
	}
	else
	{
		$('input[type=text]').attr('autocomplete', 'off');
	}

	$('img').on('dragstart', function(a){ a.preventDefault(); });

	$('.contentCKEditor a').attr('target', '_blank');
});

var _configCKEditorToClient=
{
	toolbar:
	[
		'bold',
		'italic',
		'bulletedList',
		'numberedList',
		'|',
		'link',
		'Code',
		'CodeBlock'
	]
};

if(isChrome)
{
	window.addEventListener('beforeunload', function(e)
	{
		var closeTab=true;

		$('.verifyForClose').each(function(index, element)
		{
			if($(element).val().trim()!='')
			{
				closeTab=false;

				return false;
			}
		});

		$('.verifyForCloseTable0').each(function(index, element)
		{
			if($('.verifyForCloseTable0 > tbody > tr').length>0)
			{
				closeTab=false;

				return false;
			}
		});

		$('.verifyForCloseTable1').each(function(index, element)
		{
			if($('.verifyForCloseTable1 > tbody > tr').length>1)
			{
				closeTab=false;

				return false;
			}
		});

		$('.verifyForCloseTable2').each(function(index, element)
		{
			if($('.verifyForCloseTable2 > tbody > tr').length>2)
			{
				closeTab=false;

				return false;
			}
		});

		if(!closeTab && !ignoreRestrictedClose)
		{
			var confirmationMessage='\o/';

			(e || window.event).returnValue=confirmationMessage;
			
			return confirmationMessage;
		}
	});
}

function saveCollapseMenu()
{
	localStorage.setItem('collapseMenu', !$('body').hasClass('sidebar-collapse'));
}

var _globalFunction=
{
	clickLink: function(url)
	{
		$('#modalLoading').show();
		
		window.location.href=url;
	}
};