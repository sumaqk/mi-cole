'use strict';

$(function()
{
	$('.codiTabs > a').on('click', (e) =>
	{
		$('.codiTabs > a').removeClass('codiTabsActive');

		$(e.target).addClass('codiTabsActive');

		$(e.target).parent().find('a').each((index, element) =>
		{
			$('#'+$(element).attr('attr-content')).hide();
		});

		$('#'+$(e.target).attr('attr-content')).show();
	});
});