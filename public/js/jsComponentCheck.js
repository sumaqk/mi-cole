'use strict';

$('label[class~=componentCheck').on('click', function()
{
	var hisComponentCheck=$('input[name='+$($(this).find('input[type=radio]')).attr('name')+']').parent();

	hisComponentCheck.css(
	{
		"background-color": "#ffffff"
	});

	hisComponentCheck.hover(function()
	{
		$(this).css("background-color", "#f5f5f5");
	},
	function()
	{
		$(this).css("background-color", "#ffffff");
	});

	$(this).css(
	{
		"background-color": "#fff9b0"
	});

	$(this).unbind('mouseenter').unbind('mouseleave');
});

$('label[class~=componentCheck').each(function(index, component)
{
	var hisComponentCheck=$(component).find('input[type=radio]').each(function(i, c)
	{
		if($(c).is(':checked'))
		{
			$(c).parent().css(
			{
				"background-color": "#fff9b0"
			});
		}
	});
});