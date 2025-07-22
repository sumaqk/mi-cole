<?php
namespace App\Validation;

use Illuminate\Support\Facades\Validator;

class ConfigurationValidation
{
	private $globalMessage=[];

	public function validationManagement($request)
	{
		$validator=Validator::make(
		[
			'blackLogo' => $request->input('fileBlackLogo'),
			'blackLogoMinimal' => $request->input('fileBlackLogoMinimal'),
			'whiteLogo' => $request->input('fileWhiteLogo'),
			'whiteLogoMinimal' => $request->input('fileWhiteLogoMinimal'),
			'linkedInUrl' => trim($request->input('txtLinkedInUrl')),
			'facebookUrl' => trim($request->input('txtFacebookUrl')),
			'youTubeUrl' => trim($request->input('txtYouTubeUrl')),
			'twitterUrl' => trim($request->input('txtTwitterUrl')),
			'textForPhone' => trim($request->input('txtTextForPhone')),
			'phone' => trim($request->input('txtPhone')),
			'phoneContact' => trim($request->input('txtPhoneContact')),
			'textForAddress' => trim($request->input('txtTextForAddress')),
			'address' => trim($request->input('txtAddress')),
			'fullAddress' => trim($request->input('txtFullAddress')),
			'latitudeMap' => trim($request->input('txtLatitudeMap')),
			'longitudeMap' => trim($request->input('txtLongitudeMap')),
			'zoomMap' => trim($request->input('txtZoomMap')),
			'textForDateText' => trim($request->input('txtTextForDateText')),
			'dateText' => trim($request->input('txtDateText')),
			'contactEmail' => trim($request->input('txtContactEmail')),
			'footerYear' => trim($request->input('txtFooterYear')),
			'footerText' => trim($request->input('txtFooterText')),
			'footerUrl' => trim($request->input('txtFooterUrl')),
			'urlForEmail' => trim($request->input('txtUrlForEmail')),
			'twoDescriptionBannerOne' => trim($request->input('txtTwoDescriptionBannerOne')),
			'htmlCentralDescriptionBannerOne' => trim($request->input('txtHtmlCentralDescriptionBannerOne')),
			'urlBannerOne' => trim($request->input('txtUrlBannerOne')),
			'backgroundBannerOne' => $request->input('fileBackgroundBannerOne'),
			'twoDescriptionBannerTwo' => trim($request->input('txtTwoDescriptionBannerTwo')),
			'htmlCentralDescriptionBannerTwo' => trim($request->input('txtHtmlCentralDescriptionBannerTwo')),
			'urlBannerTwo' => trim($request->input('txtUrlBannerTwo')),
			'backgroundBannerTwo' => $request->input('fileBackgroundBannerTwo'),
			'twoDescriptionBannerThree' => trim($request->input('txtTwoDescriptionBannerThree')),
			'htmlCentralDescriptionBannerThree' => trim($request->input('txtHtmlCentralDescriptionBannerThree')),
			'urlBannerThree' => trim($request->input('txtUrlBannerThree')),
			'backgroundBannerThree' => $request->input('fileBackgroundBannerThree')
		],
		[
			'blackLogo.*' => ['mimes:png,jpg,jpeg', 'size:100'],
			'blackLogoMinimal.*' => ['mimes:png,jpg,jpeg', 'size:100'],
			'whiteLogo.*' => ['mimes:png,jpg,jpeg', 'size:100'],
			'whiteLogoMinimal.*' => ['mimes:png,jpg,jpeg', 'size:100'],
			'linkedInUrl' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'facebookUrl' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'youTubeUrl' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'twitterUrl' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'textForPhone' => ['required'],
			'phone' => ['required'],
			'phoneContact' => ['required'],
			'textForAddress' => ['required'],
			'address' => ['required'],
			'fullAddress' => ['required'],
			'latitudeMap' => ['required', 'regex:/^((\-)?[0-9]{1,3}\.[0-9]{2,15})?$/'],
			'longitudeMap' => ['required', 'regex:/^((\-)?[0-9]{1,3}\.[0-9]{2,15})?$/'],
			'zoomMap' => ['required', 'regex:/^([1-9]{1}[0-9]*)?$/'],
			'textForDateText' => ['required'],
			'dateText' => ['required'],
			'contactEmail' => ['required', 'regex:/^([a-zA-Z0-9\.\-_]+\@[a-zA-Z0-9\-_]+\.([a-zA-Z0-9\-_]+\.)?[a-zA-Z]+(\.[a-zA-Z]+)?)?$/'],
			'footerYear' => ['required', 'regex:/^(20[0-9]{2})?$/'],
			'footerText' => ['required'],
			'footerUrl' => ['required', 'regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'urlForEmail' => ['required', 'regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'twoDescriptionBannerOne' => ['required'],
			'htmlCentralDescriptionBannerOne' => ['required'],
			'urlBannerOne' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'backgroundBannerOne.*' => ['mimes:png,jpg,jpeg', 'size:700'],
			'twoDescriptionBannerTwo' => ['required'],
			'htmlCentralDescriptionBannerTwo' => ['required'],
			'urlBannerTwo' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'backgroundBannerTwo.*' => ['mimes:png,jpg,jpeg', 'size:700'],
			'twoDescriptionBannerThree' => ['required'],
			'htmlCentralDescriptionBannerThree' => ['required'],
			'urlBannerThree' => ['regex:/^(https?:\/\/){1}((?:www\.|(?!www))[^\s\.\"\']+\.[^\s\"\']{2,}|www\.[^\s\"\']+\.[^\s\"\']{2,})?$/i'],
			'backgroundBannerThree.*' => ['mimes:png,jpg,jpeg', 'size:700']
		],
		[
			'blackLogo.mimes' => 'El archivo "blackLogo" no tiene un formato permitido.',
			'blackLogo.size' => 'El archivo "blackLogo" excede el tamaño permitido.',
			'blackLogoMinimal.mimes' => 'El archivo "blackLogoMinimal" no tiene un formato permitido.',
			'blackLogoMinimal.size' => 'El archivo "blackLogoMinimal" excede el tamaño permitido.',
			'whiteLogo.mimes' => 'El archivo "whiteLogo" no tiene un formato permitido.',
			'whiteLogo.size' => 'El archivo "whiteLogo" excede el tamaño permitido.',
			'whiteLogoMinimal.mimes' => 'El archivo "whiteLogoMinimal" no tiene un formato permitido.',
			'whiteLogoMinimal.size' => 'El archivo "whiteLogoMinimal" excede el tamaño permitido.',
			'linkedInUrl.regex' => 'El campo "LinkedInUrl" no cumple con la expresión necesaria.',
			'facebookUrl.regex' => 'El campo "FacebookUrl" no cumple con la expresión necesaria.',
			'youTubeUrl.regex' => 'El campo "YouTubeUrl" no cumple con la expresión necesaria.',
			'twitterUrl.regex' => 'El campo "TwitterUrl" no cumple con la expresión necesaria.',
			'textForPhone.required' => 'El campo "textForPhone" es requerido.',
			'phone.required' => 'El campo "phone" es requerido.',
			'phoneContact.required' => 'El campo "phoneContact" es requerido.',
			'textForAddress.required' => 'El campo "textForAddress" es requerido.',
			'address.required' => 'El campo "address" es requerido.',
			'fullAddress.required' => 'El campo "fullAddress" es requerido.',
			'latitudeMap.required' => 'El campo "latitudeMap" es requerido.',
			'latitudeMap.regex' => 'El campo "latitudeMap" no cumple con la expresión necesaria.',
			'longitudeMap.required' => 'El campo "longitudeMap" es requerido.',
			'longitudeMap.regex' => 'El campo "longitudeMap" no cumple con la expresión necesaria.',
			'zoomMap.required' => 'El campo "zoomMap" es requerido.',
			'zoomMap.regex' => 'El campo "zoomMap" no cumple con la expresión necesaria.',
			'textForDateText.required' => 'El campo "textForDateText" es requerido.',
			'dateText.required' => 'El campo "dateText" es requerido.',
			'contactEmail.required' => 'El campo "contactEmail" es requerido.',
			'contactEmail.regex' => 'El campo "contactEmail" no cumple con la expresión necesaria.',
			'footerYear.required' => 'El campo "footerYear" es requerido.',
			'footerYear.regex' => 'El campo "footerYear" no cumple con la expresión necesaria.',
			'footerText.required' => 'El campo "footerText" es requerido.',
			'footerUrl.required' => 'El campo "footerUrl" es requerido.',
			'footerUrl.regex' => 'El campo "footerUrl" no cumple con la expresión necesaria.',
			'urlForEmail.required' => 'El campo "urlForEmail" es requerido.',
			'urlForEmail.regex' => 'El campo "urlForEmail" no cumple con la expresión necesaria.',
			'twoDescriptionBannerOne.required' => 'El campo "twoDescriptionBannerOne" es requerido.',
			'htmlCentralDescriptionBannerOne.required' => 'El campo "htmlCentralDescriptionBannerOne" es requerido.',
			'urlBannerOne.required' => 'El campo "urlBannerOne" es requerido.',
			'backgroundBannerOne.mimes' => 'El archivo "backgroundBannerOne" no tiene un formato permitido.',
			'backgroundBannerOne.size' => 'El archivo "backgroundBannerOne" excede el tamaño permitido.',
			'twoDescriptionBannerTwo.required' => 'El campo "twoDescriptionBannerTwo" es requerido.',
			'htmlCentralDescriptionBannerTwo.required' => 'El campo "htmlCentralDescriptionBannerTwo" es requerido.',
			'urlBannerTwo.required' => 'El campo "urlBannerTwo" es requerido.',
			'backgroundBannerTwo.mimes' => 'El archivo "backgroundBannerTwo" no tiene un formato permitido.',
			'backgroundBannerTwo.size' => 'El archivo "backgroundBannerTwo" excede el tamaño permitido.',
			'twoDescriptionBannerThree.required' => 'El campo "twoDescriptionBannerThree" es requerido.',
			'htmlCentralDescriptionBannerThree.required' => 'El campo "htmlCentralDescriptionBannerThree" es requerido.',
			'urlBannerThree.required' => 'El campo "urlBannerThree" es requerido.',
			'backgroundBannerThree.mimes' => 'El archivo "backgroundBannerThree" no tiene un formato permitido.',
			'backgroundBannerThree.size' => 'El archivo "backgroundBannerThree" excede el tamaño permitido.'
		]);

		if($validator->fails())
		{
			$errors=$validator->errors()->all();

			foreach($errors as $value)
			{
				$this->globalMessage[]=$value;
			}
		}

		return $this->globalMessage;
	}
}
?>