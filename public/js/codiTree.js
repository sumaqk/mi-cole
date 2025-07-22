'use strict';

function initCodiTree()
{
	$('.codiTreeLineHorizontalConnector').remove();
	$('.codiTreeLineVerticalConnectorTop').remove();
	$('.codiTreeLineVerticalConnectorBottom').remove();

	$('.codiTree').each((index, element) =>
	{
		$(element).find('li > ul').each((key, item) =>
		{
			$(element).append('<div class="codiTreeLineHorizontalConnector"></div>');

			$(item).find('> li > div').each((key2, item2) =>
			{
				$(item2).append('<div class="codiTreeLineVerticalConnectorTop"></div>');

				$(item2).find('.codiTreeLineVerticalConnectorTop').css(
				{
					"border-left": "1px dashed #000000",
					"height": "30px",
					"left": "50%",
					"position": "absolute",
					"bottom": "100%",
					"width": "1px"
				});
			})

			$(item).prev().append('<div class="codiTreeLineVerticalConnectorBottom"></div>');

			$(item).prev().find('.codiTreeLineVerticalConnectorBottom').css(
			{
				"border-left": "1px dashed #000000",
				"height": "30px",
				"left": "50%",
				"position": "absolute",
				"top": "100%",
				"width": "1px"
			});
		});
	});

	$('.codiTree').each((index, element) =>
	{
		$(element).find('li > ul').each((key, item) =>
		{
			if(!$(item).find('> li > div').length)
			{
				return true;
			}

			$($(element).find('.codiTreeLineHorizontalConnector')[key]).css(
			{
				"border-bottom": "1px dashed #000000",
				"height": "1px",
				"left": (($($(item).find('> li > div').first()).offset().left+($($(item).find('> li > div').first()).css('width').substring(0, $($(item).find('> li > div').first()).css('width').length-2)/2))-$(element).offset().left)+'px',
				"position": "absolute",
				"top": ($($(item).find('> li > div').first()).offset().top-$(element).offset().top-($('.codiTreeLineVerticalConnectorBottom').first().height()))+'px',
				"width": (($($(item).find('> li > div').last()).offset().left+(parseFloat(($($(item).find('> li > div').first()).css('width').substring(0, $($(item).find('> li > div').first()).css('width').length-2)))/2))-(($($(item).find('> li > div').first()).offset().left)+(parseFloat(($($(item).find('> li > div').first()).css('width').substring(0, $($(item).find('> li > div').first()).css('width').length-2)))/2)))+'px'
			});
		});
	});
}

initCodiTree();