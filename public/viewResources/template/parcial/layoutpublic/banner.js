'use strict';

function changeBannerShow()
{
	window.setTimeout(() =>
	{
		var currentBanner=$('.divPrincipalBanner[class~="divPrincipalBannerActive"]');
		var currentBannerClass=currentBanner.attr('class').split(' ')[1];

		currentBanner.removeClass('divPrincipalBannerActive');

		switch(currentBannerClass)
		{
			case 'divPrincipalBannerOne':
				$('.divPrincipalBannerTwo').addClass('divPrincipalBannerActive');
			break;

			case 'divPrincipalBannerTwo':
				$('.divPrincipalBannerThree').addClass('divPrincipalBannerActive');
			break;

			case 'divPrincipalBannerThree':
				$('.divPrincipalBannerOne').addClass('divPrincipalBannerActive');
			break;
		}

		changeBannerShow();
	}, 15000);
}

changeBannerShow();