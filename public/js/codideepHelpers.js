String.prototype.viiReplaceAll=function(text, newText)
{
	return this.toString().replace(new RegExp(text, 'g'), newText);
}

String.prototype.viiInjectionEscape=function()
{
	var specialChar=
	{
		'<': '&lt;',
		'>': '&gt;',
		'"': '&quot;',
		"'": '&#39',
		'/': '&#47;',
		'\\': '&#92;'
	};

	return this.toString().replace(/[<>'"]/g, function(key){ return specialChar[key]; });
}

var evtTimeOutJsFind='';

function addSlashes(text)
{
	return text.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, "\\$1");
}

function textAdapter(text)
{
	var regularExpresion;
	var acent="ÀÁÈÉÌÍÒÓÙÚàáèéìíòóùú";
	var normalText="AAEEIIOOUUaaeeiioouu";

	for(var i=0; i<acent.length; i++)
	{
		regularExpresion=new RegExp(acent.charAt(i),"g");
		text=text.replace(regularExpresion, normalText.charAt(i));
	}

	return text;
}

function filterContent(idContainer, text, onKeyUp, delay, event)
{
	var evt=event || window.event;

	var code=evt.charCode || evt.keyCode || evt.which;

	if(code==13 || onKeyUp)
	{
		if(evtTimeOutJsFind!='')
		{
			clearTimeout(evtTimeOutJsFind);
			evtTimeOutJsFind='';
		}

		evtTimeOutJsFind=setTimeout(function()
		{
			text=textAdapter(text);

			var world=text.split(/ /);

			var worldAdapter='';

			for(var i=0; i<world.length; i++)
			{
				if(world[i]!='')
				{
					worldAdapter+=' '+world[i];
				}
			}

			worldAdapter=worldAdapter.substring(1);
			worldAdapter=addSlashes(worldAdapter);
			worldAdapter=worldAdapter.split(/ /);

			var worldRegularExpresion;
			var regularExpresion;
			var showResult;
			var containerFind=document.getElementById(idContainer);
			var filterElement=containerFind.getElementsByClassName('filterElement');

			var lengthFilterElement=filterElement.length;
			var lengthWorldAdapter=worldAdapter.length;

			var displayDefect='';
			var displayDefectAssigned=false;

			if(!displayDefectAssigned)
			{
				for(var i=0; i<lengthFilterElement; i++)
				{
					if(filterElement[i].style.display!='none')
					{
						displayDefect=filterElement[i].style.display;
						displayDefectAssigned=true;

						break;
					}
				}
			}

			if(world=='')
			{
				for(var i=0; i<lengthFilterElement; i++)
				{
					filterElement[i].style.display=displayDefect;
				}

				return;
			}

			var element;

			for(var i=0; i<lengthFilterElement; i++)
			{
				element=filterElement[i];

				showResult=true;

				for(var j=0; j<lengthWorldAdapter; j++)
				{
					worldRegularExpresion=worldAdapter[j];

					regularExpresion=new RegExp(worldRegularExpresion, 'i');

					if(!regularExpresion.test(textAdapter((element.textContent!='undefined' ? element.textContent : element.innerText).replace(/\s/g,''))))
					{
						showResult=false;

						break;
					}
				}

				if(showResult)
				{
					element.style.display=displayDefect;
				}
				else
				{
					element.style.display='none';
				}
			}
		}, delay);
	}
}

function ajaxDialog(idContainer, classWidthDialog, title, data, url, method, preFunction, postFunction, cache, async)
{
	
	$('#'+idContainer).html('');

	if((typeof preFunction)=='function')
	{
		preFunction();
	}

	$('#modalLoading').show();
	
	$.ajax(
	{
		url: url,
		type: method,
		data: data,
		cache: cache,
		async: async
	}).done(function(page)
	{
		$('#modalLoading').hide();
		
		var htmlResponse='<div class="modal fade" id="'+idContainer+'Modal" data-backdrop="static" data-keyboard="false">'
			+'<div class="modal-dialog ' + (classWidthDialog != null && classWidthDialog != undefined ? classWidthDialog : '') + '">'
				+'<div class="modal-content">'
					+'<div class="modal-header">'
						+'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
						+'<span aria-hidden="true">&times;</span></button>'
						+'<h4 class="modal-title">'+title+'</h4>'
					+'</div>'
					+'<div class="modal-body">'
						+page
					+'</div>'
				+'</div>'
			+'</div>'
		+'</div>';
		
		$('#'+idContainer).html(htmlResponse);

		$('#'+idContainer+'Modal').modal('show');

		if((typeof postFunction)=='function')
		{
			postFunction();
		}
	}).fail(function()
	{
		$('#modalLoading').hide();
		$('#'+idContainer).html('<div class="callout callout-danger">Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "eluyot@legado.gob.pe". Pedimos disculpas y damos gracias por su comprensión.</div>');
	});
}

function ajaxPage(idContainer, data, url, method, preFunction, postFunction, cache, async)
{
	if((typeof preFunction)=='function')
	{
		preFunction();
	}

	$('#modalLoading').show();
	
	$.ajax(
	{
		url: url,
		type: method,
		data: data,
		cache: cache,
		async: async
	}).done(function(page)
	{
		$('#modalLoading').hide();
		$('#'+idContainer).html(page);

		if((typeof postFunction)=='function')
		{
			postFunction();
		}
	}).fail(function()
	{
		$('#modalLoading').hide();
		$('#'+idContainer).html('<div class="callout callout-danger">Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "eluyot@legado.gob.pe". Pedimos disculpas y damos gracias por su comprensión.</div>');
	});
}

function ajaxJson(data, url, method, preFunction, postFunction, cache, async)
{    
	if((typeof preFunction)=='function')
	{
		preFunction();
	}

	$('#modalLoading').show();
	
	$.ajax(
	{
		url: url,
		type: method,
		data: data,
		cache: cache,
		async: async
	}).done(function(objectJSON)
	{
		$('#modalLoading').hide();

		if((typeof postFunction)=='function')
		{
			postFunction(objectJSON);
		}
	}).fail(function()
	{
		$('#modalLoading').hide();

		var objectJSON=
		{
			error: true,
			messageGlobal: 'Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "eluyot@legado.gob.pe". Pedimos disculpas y damos gracias por su comprensión.'
		};
		
		if((typeof postFunction)=='function')
		{
			postFunction(objectJSON);
		}
	});
}

function ajaxScrollDown(idSection, data, url, method, preFunction, postFunction, cache, async, tagLoadingAdd)
{
	if((typeof preFunction)=='function')
	{
		preFunction();
	}

	$('#'+idSection).append('<'+tagLoadingAdd+' id="tagLoadingAdd" style="background-color: #f5f5f5;color: #999999;padding: 7px;text-align: center;" class="opacityAnimation">Cargando...</'+tagLoadingAdd+'>');
	
	$('#'+idSection).animate({ scrollTop: $('#'+idSection)[0].scrollHeight}, 0);

	$.ajax(
	{
		url: url,
		type: method,
		data: data,
		cache: cache,
		async: async
	}).done(function(pagina)
	{
		$('#tagLoadingAdd').remove();
		$('#'+idSection).append(pagina);

		if((typeof postFunction)=='function')
		{
			postFunction();
		}
	}).fail(function()
	{
		$('#tagLoadingAdd').remove();
		$('#'+idSection).html('<div class="callout callout-danger">Ocurrió un error inesperado. Por favor reporte esto a la plataforma o al correo "eluyot@legado.gob.pe". Pedimos disculpas y damos gracias por su comprensión.</div>');
	});
}

function clearInputText(idContainer, arrayIdException)
{
	var sizeArrayIdException=arrayIdException==null ? 0 : arrayIdException.length;

	$("#"+idContainer).find('input[type=text]').each(function(index, element)
	{
		var clearContent=true;

		for(var i=0; i<sizeArrayIdException; i++)
		{
			if(arrayIdException[i]==$(element).attr('id'))
			{
				clearContent=false;

				break;
			}
		}

		if(clearContent)
		{
			$(element).val(null);
		}
	});
}

function clearTextArea(idContainer, arrayIdException)
{
	var sizeArrayIdException=arrayIdException==null ? 0 : arrayIdException.length;

	$('#'+idContainer).find('textarea').each(function(index, element)
	{
		var clearContent=true;
		
		for(var i=0; i<sizeArrayIdException; i++)
		{
			if(arrayIdException[i]==$(element).attr('id'))
			{
				clearContent=false;

				break;
			}
		}

		if(clearContent)
		{
			$(element).val(null);
		}
	});
}

function scapeSpecialChar(text)
{
	return text.replace(/([.*+?^=!:${}()|\[\]\/\\])/g, '\\$1');
}

function removeAcentMark(text)
{
	var regularExpresion;
	var acent='ÀÁÈÉÌÍÒÓÙÚàáèéìíòóùú';
	var normalText='AAEEIIOOUUaaeeiioouu';

	for(var i=0; i<acent.length; i++)
	{
		regularExpresion=new RegExp(acent.charAt(i), 'g');
		text=text.replace(regularExpresion, normalText.charAt(i));
	}

	return text;
}

function preViewImage(inputFile, idControlImg)
{
	$('#'+idControlImg).attr('src', '');

	if(inputFile.files && inputFile.files[0])
	{
		var reader=new FileReader();

		reader.onload=function(e)
		{
			$('#'+idControlImg).attr('src', e.target.result);
		};

		reader.readAsDataURL(inputFile.files[0]);
	}
}

function sizeFileKb(file)
{	
	return (((file.size)/1024));
}

function sizeFileInputKb(inputFile)
{
	if(inputFile.files && inputFile.files[0])
	{
		return (((inputFile.files[0].size)/1024));
	}

	return 0;
}

function quantityDaysMonth(month, year)
{
	return new Date(year || new Date().getFullYear(), month, 0).getDate();
}

function actualDayWeek(date)
{
	while(date.toString().indexOf('-')!=-1)
	{
		date=date.toString().replace('-', '/');
	}

	return new Date(date).getDay();
}

function confirmDialog(callback)
{
	swal(
	{
		title : 'Confirmar operación',
		text : '¿Realmente desea proceder?',
		icon : 'warning',
		buttons : ['No, cancelar.', 'Si, proceder.']
	})
	.then((proceed) =>
	{
		if(proceed)
		{
			callback();
		}
	});
}

function confirmDialogSend(idFrm)
{
	swal(
	{
		title : 'Confirmar operación',
		text : '¿Realmente desea proceder?',
		icon : 'warning',
		buttons : ['No, cancelar.', 'Si, proceder.']
	})
	.then((proceed) =>
	{
		if(proceed)
		{
			ignoreRestrictedClose=true;

			$('#modalLoading').show();
			
			$('#'+idFrm)[0].submit();
		}
	});
}

function warningNote(title, message)
{
	new PNotify(
	{
		title : title,
		text : message,
		type : 'warning'
	});
}

function errorNote(title, message)
{
	new PNotify(
	{
		title : title,
		text : message,
		type : 'error'
	});
}

function incorrectNote()
{
	new PNotify(
	{
		title : 'No se pudo proceder',
		text : 'Por favor complete y corrija toda la información necesaria antes de continuar.',
		type : 'error'
	});
}

function successNote(title, message)
{
	new PNotify(
	{
		title : title,
		text : message,
		type : 'info'
	});
}

function correctNote()
{
	new PNotify(
	{
		title : 'Operación correcta',
		text : 'Operación realizada correctamente.',
		type : 'info'
	});
}

function currentDateZone(timeZone)
{
	var dateTemp=new Date(moment.tz(new Date(), timeZone).format('YYYY-MM-DD HH:mm:ss')), secondsTemp=''+dateTemp.getSeconds(), minutesTemp=''+dateTemp.getMinutes(), hoursTemp=''+dateTemp.getHours(), dayTemp=''+dateTemp.getDate(), monthTemp=''+(dateTemp.getMonth()+1), yearTemp=dateTemp.getFullYear();

	if(monthTemp.length<2) monthTemp='0'+monthTemp;
	if(dayTemp.length<2) dayTemp='0'+dayTemp;
	if(hoursTemp.length<2) hoursTemp='0'+hoursTemp;
	if(minutesTemp.length<2) minutesTemp='0'+minutesTemp;
	if(secondsTemp.length<2) secondsTemp='0'+secondsTemp;

	return [yearTemp, monthTemp, dayTemp].join('-')+' '+[hoursTemp, minutesTemp, secondsTemp].join(':');
}

function getNumberFromText(text)
{	
	return parseInt(text.match(/\d/g).join(''));
}

function keyUpEnter(event)
{
	var evt=event || window.event;

	var code=evt.charCode || evt.keyCode || evt.which;

	if(code==13 && !evt.shiftKey)
	{
		return true;
	}

	return false;
}

function lineJumpTextArea(element, enter, shiftEnter, event)
{
	var evt=event || window.event;

	var code=evt.charCode || evt.keyCode || evt.which;

	if((enter && code==13) || (shiftEnter && evt.shiftKey && code==13))
	{
		$(element).val($(element).val()+'\n');
	}
}

function copyHtml(idContainer, titleMessage, bodyMessage)
{
	var auxTemp=document.createElement('input');
	
	auxTemp.setAttribute('value', document.getElementById(idContainer).innerHTML);

	document.body.appendChild(auxTemp);

	auxTemp.select();

	document.execCommand('copy');

	document.body.removeChild(auxTemp);

	correctNote(titleMessage, bodyMessage);
}

function objectValidate(fieldsValidate)
{
	return {
		framework: 'bootstrap',
		excluded: [':disabled', '[class*="notValidate"]'],
		live: 'enabled',
		message: '<b style="color: #9d9d9d;">Asegúrese que realmente no necesita este valor.</b>',
		trigger: null,
		fields: fieldsValidate
	};
}

function renderPagination(totalRow, currentPage, perPage)
{
	var quantityPage=Math.ceil(totalRow/perPage);

	currentPage=currentPage>quantityPage ? quantityPage : (currentPage<1 ? 1 : currentPage);

	var htmlTemp='';

	for(var i=0; i<quantityPage; i++)
	{
		if(quantityPage>7)
		{
			if(i+1==quantityPage && currentPage<quantityPage-3)
			{
				htmlTemp+='...';
			}

			if(i==0 || i+1==quantityPage || (i+1)>=currentPage-2 && (i+1)<=currentPage+2)
			{
				htmlTemp+='<span class="divPaginationNumberPage'+(currentPage==(i+1) ? ' divPaginationCurrentPage' : '')+'" onclick="onClickPagePagination(this, \''+(i+1)+'\');">'+(i+1)+'</span>';
			}

			if(i==0 && currentPage>4)
			{
				htmlTemp+='...';
			}
		}
		else
		{
			htmlTemp+='<span class="divPaginationNumberPage'+(currentPage==(i+1) ? ' divPaginationCurrentPage' : '')+'">'+(i+1)+'</span>';
		}
	}

	$('.divPagination').html(htmlTemp);

	$('.divPagination').css(
	{
		"display": "block",
		"font-size": "11px"
	});

	$('.divPagination > .divPaginationNumberPage').css(
	{
		"background-color": "#ffffff",
		"border": "1px solid #999999",
		"color": "#000000",
		"cursor": "pointer",
		"display": "inline-block",
		"margin": "1px",
		"padding": "4px",
		"text-align": "center",
		"min-width": "40px"
	});

	$('.divPagination > .divPaginationNumberPage:not(.divPaginationCurrentPage)').hover(function()
	{
		$(this).css(
		{
			"background-color": "#e5e5e5",
			"color": "#000000"
		});
	},
	function()
	{
		$(this).css(
		{
			"background-color": "#ffffff",
			"color": "#000000"
		});
	});

	$('.divPagination > .divPaginationCurrentPage').css(
	{
		"background-color": "#2983e1",
		"color": "#ffffff"
	});
}

function timeZoneCurrentDate(timeZone)
{
	var dateTemp=new Date(moment.tz(new Date(), timeZone).format('YYYY-MM-DD HH:mm:ss')), secondsTemp=''+dateTemp.getSeconds(), minutesTemp=''+dateTemp.getMinutes(), hoursTemp=''+dateTemp.getHours(), dayTemp=''+dateTemp.getDate(), monthTemp=''+(dateTemp.getMonth()+1), yearTemp=dateTemp.getFullYear();

	if(monthTemp.length<2) monthTemp='0'+monthTemp;
	if(dayTemp.length<2) dayTemp='0'+dayTemp;
	if(hoursTemp.length<2) hoursTemp='0'+hoursTemp;
	if(minutesTemp.length<2) minutesTemp='0'+minutesTemp;
	if(secondsTemp.length<2) secondsTemp='0'+secondsTemp;

	return [yearTemp, monthTemp, dayTemp].join('-')+' '+[hoursTemp, minutesTemp, secondsTemp].join(':');
}

function strPad(number, strComplete, length)
{
	var numberTemp=''+number;
	var padTemp=strComplete.repeat(length);
	var numberTemp=padTemp.substring(0, padTemp.length-numberTemp.length)+numberTemp;

	return numberTemp;
}

function validateExtension(inputFile, arrayExtension)
{
	if(arrayExtension.indexOf(inputFile.files[0].name.split('.').pop().toLowerCase())==-1)
	{
		return false;
	}

	return true;
}