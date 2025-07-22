<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Helper\PlatformHelper;
use Illuminate\Http\Request;

use App\Validation\ConfigurationValidation;

use Illuminate\Support\Facades\DB;

use App\Models\TConfiguration;

class ConfigurationController extends Controller
{
	public function actionManagement(Request $request)
	{
		if($_POST)
		{
			try
			{
				DB::beginTransaction();

				$this->_so->mo->listMessage=(new ConfigurationValidation())->validationManagement($request);

				if($this->_so->mo->existsMessage())
				{
					DB::rollBack();

					return PlatformHelper::redirectError($this->_so->mo->listMessage, 'configuration/management');
				}

				$tConfiguration=TConfiguration::first();

				$fileBlackLogoExtension='';
				$fileBlackLogoMinimalExtension='';
				$fileWhiteLogoExtension='';
				$fileWhiteLogoMinimalExtension='';
				$fileBackgroundBannerOneExtension='';
				$fileBackgroundBannerTwoExtension='';
				$fileBackgroundBannerThreeExtension='';

				if($request->hasFile('fileBlackLogo'))
				{
					$fileBlackLogoExtension=strtolower($request->file('fileBlackLogo')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/logo/'.$tConfiguration->idConfiguration.'-blackLogo.'.$tConfiguration->blackLogoExtension)))
					{
						unlink(public_path('img/logo/'.$tConfiguration->idConfiguration.'-blackLogo.'.$tConfiguration->blackLogoExtension));
					}

					if($tConfiguration!=null && file_exists(public_path('resources_global/'.'logo.'.$tConfiguration->blackLogoExtension)))
					{
						unlink(public_path('resources_global/'.'logo.'.$tConfiguration->blackLogoExtension));
					}
				}

				if($request->hasFile('fileBlackLogoMinimal'))
				{
					$fileBlackLogoMinimalExtension=strtolower($request->file('fileBlackLogoMinimal')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/logo/'.$tConfiguration->idConfiguration.'-blackLogoMinimal.'.$tConfiguration->blackLogoMinimalExtension)))
					{
						unlink(public_path('img/logo/'.$tConfiguration->idConfiguration.'-blackLogoMinimal.'.$tConfiguration->blackLogoMinimalExtension));
					}
				}

				if($request->hasFile('fileWhiteLogo'))
				{
					$fileWhiteLogoExtension=strtolower($request->file('fileWhiteLogo')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/logo/'.$tConfiguration->idConfiguration.'-whiteLogo.'.$tConfiguration->whiteLogoExtension)))
					{
						unlink(public_path('img/logo/'.$tConfiguration->idConfiguration.'-whiteLogo.'.$tConfiguration->whiteLogoExtension));
					}
				}

				if($request->hasFile('fileWhiteLogoMinimal'))
				{
					$fileWhiteLogoMinimalExtension=strtolower($request->file('fileWhiteLogoMinimal')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/logo/'.$tConfiguration->idConfiguration.'-whiteLogoMinimal.'.$tConfiguration->whiteLogoMinimalExtension)))
					{
						unlink(public_path('img/logo/'.$tConfiguration->idConfiguration.'-whiteLogoMinimal.'.$tConfiguration->whiteLogoMinimalExtension));
					}
				}

				if($request->hasFile('fileBackgroundBannerOne'))
				{
					$fileBackgroundBannerOneExtension=strtolower($request->file('fileBackgroundBannerOne')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner01.'.$tConfiguration->backgroundBannerOneExtension)))
					{
						unlink(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner01.'.$tConfiguration->backgroundBannerOneExtension));
					}
				}

				if($request->hasFile('fileBackgroundBannerTwo'))
				{
					$fileBackgroundBannerTwoExtension=strtolower($request->file('fileBackgroundBannerTwo')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner02.'.$tConfiguration->backgroundBannerTwoExtension)))
					{
						unlink(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner02.'.$tConfiguration->backgroundBannerTwoExtension));
					}
				}

				if($request->hasFile('fileBackgroundBannerThree'))
				{
					$fileBackgroundBannerThreeExtension=strtolower($request->file('fileBackgroundBannerThree')->getClientOriginalExtension());

					if($tConfiguration!=null && file_exists(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner03.'.$tConfiguration->backgroundBannerThreeExtension)))
					{
						unlink(public_path('img/banner/'.$tConfiguration->idConfiguration.'-banner03.'.$tConfiguration->backgroundBannerThreeExtension));
					}
				}

				$notExistsPreviously=false;

				if($tConfiguration==null)
				{
					$notExistsPreviously=true;

					$tConfiguration=new TConfiguration();

					$tConfiguration->idConfiguration=uniqid();
				}

				$tConfiguration->platformName=trim($request->input('txtPlatformName'));
				$tConfiguration->platformTitle=trim($request->input('txtPlatformTitle'));
				$tConfiguration->blackLogoExtension=($fileBlackLogoExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->blackLogoExtension) : $fileBlackLogoExtension);
				$tConfiguration->blackLogoMinimalExtension=($fileBlackLogoMinimalExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->blackLogoMinimalExtension) : $fileBlackLogoMinimalExtension);
				$tConfiguration->whiteLogoExtension=($fileWhiteLogoExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->whiteLogoExtension) : $fileWhiteLogoExtension);
				$tConfiguration->whiteLogoMinimalExtension=($fileWhiteLogoMinimalExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->whiteLogoMinimalExtension) : $fileWhiteLogoMinimalExtension);
				$tConfiguration->linkedInUrl=trim($request->input('txtLinkedInUrl'));
				$tConfiguration->facebookUrl=trim($request->input('txtFacebookUrl'));
				$tConfiguration->youTubeUrl=trim($request->input('txtYouTubeUrl'));
				$tConfiguration->twitterUrl=trim($request->input('txtTwitterUrl'));
				$tConfiguration->textForPhone=trim($request->input('txtTextForPhone'));
				$tConfiguration->phone=trim($request->input('txtPhone'));
				$tConfiguration->phoneContact=trim($request->input('txtPhoneContact'));
				$tConfiguration->textForAddress=trim($request->input('txtTextForAddress'));
				$tConfiguration->address=trim($request->input('txtAddress'));
				$tConfiguration->fullAddress=trim($request->input('txtFullAddress'));
				$tConfiguration->latitudeMap=trim($request->input('txtLatitudeMap'));
				$tConfiguration->longitudeMap=trim($request->input('txtLongitudeMap'));
				$tConfiguration->zoomMap=trim($request->input('txtZoomMap'));
				$tConfiguration->textForDateText=trim($request->input('txtTextForDateText'));
				$tConfiguration->dateText=trim($request->input('txtDateText'));
				$tConfiguration->contactEmail=trim($request->input('txtContactEmail'));
				$tConfiguration->footerYear=trim($request->input('txtFooterYear'));
				$tConfiguration->footerText=trim($request->input('txtFooterText'));
				$tConfiguration->footerUrl=trim($request->input('txtFooterUrl'));
				$tConfiguration->urlForEmail=trim($request->input('txtUrlForEmail'));
				$tConfiguration->apiKeyGoogleMaps=trim($request->input('txtApiKeyGoogleMaps'));
				$tConfiguration->oneDescriptionBannerOne=trim($request->input('txtOneDescriptionBannerOne'));
				$tConfiguration->twoDescriptionBannerOne=trim($request->input('txtTwoDescriptionBannerOne'));
				$tConfiguration->htmlCentralDescriptionBannerOne=trim($request->input('txtHtmlCentralDescriptionBannerOne'));
				$tConfiguration->urlBannerOne=trim($request->input('txtUrlBannerOne'));
				$tConfiguration->textUrlBannerOne=trim($request->input('txtTextUrlBannerOne'));
				$tConfiguration->htmlOneFooterBannerOne=trim($request->input('txtHtmlOneFooterBannerOne'));
				$tConfiguration->htmlTwoFooterBannerOne=trim($request->input('txtHtmlTwoFooterBannerOne'));
				$tConfiguration->htmlThreeFooterBannerOne=trim($request->input('txtHtmlThreeFooterBannerOne'));
				$tConfiguration->backgroundBannerOneExtension=($fileBackgroundBannerOneExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->backgroundBannerOneExtension) : $fileBackgroundBannerOneExtension);
				$tConfiguration->oneDescriptionBannerTwo=trim($request->input('txtOneDescriptionBannerTwo'));
				$tConfiguration->twoDescriptionBannerTwo=trim($request->input('txtTwoDescriptionBannerTwo'));
				$tConfiguration->htmlCentralDescriptionBannerTwo=trim($request->input('txtHtmlCentralDescriptionBannerTwo'));
				$tConfiguration->urlBannerTwo=trim($request->input('txtUrlBannerTwo'));
				$tConfiguration->textUrlBannerTwo=trim($request->input('txtTextUrlBannerTwo'));
				$tConfiguration->htmlOneFooterBannerTwo=trim($request->input('txtHtmlOneFooterBannerTwo'));
				$tConfiguration->htmlTwoFooterBannerTwo=trim($request->input('txtHtmlTwoFooterBannerTwo'));
				$tConfiguration->htmlThreeFooterBannerTwo=trim($request->input('txtHtmlThreeFooterBannerTwo'));
				$tConfiguration->backgroundBannerTwoExtension=($fileBackgroundBannerTwoExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->backgroundBannerTwoExtension) : $fileBackgroundBannerTwoExtension);
				$tConfiguration->oneDescriptionBannerThree=trim($request->input('txtOneDescriptionBannerThree'));
				$tConfiguration->twoDescriptionBannerThree=trim($request->input('txtTwoDescriptionBannerThree'));
				$tConfiguration->htmlCentralDescriptionBannerThree=trim($request->input('txtHtmlCentralDescriptionBannerThree'));
				$tConfiguration->urlBannerThree=trim($request->input('txtUrlBannerThree'));
				$tConfiguration->textUrlBannerThree=trim($request->input('txtTextUrlBannerThree'));
				$tConfiguration->htmlOneFooterBannerThree=trim($request->input('txtHtmlOneFooterBannerThree'));
				$tConfiguration->htmlTwoFooterBannerThree=trim($request->input('txtHtmlTwoFooterBannerThree'));
				$tConfiguration->htmlThreeFooterBannerThree=trim($request->input('txtHtmlThreeFooterBannerThree'));
				$tConfiguration->backgroundBannerThreeExtension=($fileBackgroundBannerThreeExtension=='' ? ($notExistsPreviously ? '' : $tConfiguration->backgroundBannerThreeExtension) : $fileBackgroundBannerThreeExtension);
				$tConfiguration->updated_at=$this->_currentDate;

				$tConfiguration->save();

				if($request->hasFile('fileBlackLogo'))
				{
					$request->file('fileBlackLogo')->move(public_path('img/logo'), $tConfiguration->idConfiguration.'-blackLogo.'.$fileBlackLogoExtension);

					copy(public_path('img/logo/'.$tConfiguration->idConfiguration.'-blackLogo.'.$fileBlackLogoExtension), public_path('resources_global/logo.'.$fileBlackLogoExtension));
				}

				if($request->hasFile('fileBlackLogoMinimal'))
				{
					$request->file('fileBlackLogoMinimal')->move(public_path('img/logo'), $tConfiguration->idConfiguration.'-blackLogoMinimal.'.$fileBlackLogoMinimalExtension);
				}

				if($request->hasFile('fileWhiteLogo'))
				{
					$request->file('fileWhiteLogo')->move(public_path('img/logo'), $tConfiguration->idConfiguration.'-whiteLogo.'.$fileWhiteLogoExtension);
				}

				if($request->hasFile('fileWhiteLogoMinimal'))
				{
					$request->file('fileWhiteLogoMinimal')->move(public_path('img/logo'), $tConfiguration->idConfiguration.'-whiteLogoMinimal.'.$fileWhiteLogoMinimalExtension);
				}

				if($request->hasFile('fileBackgroundBannerOne'))
				{
					$request->file('fileBackgroundBannerOne')->move(public_path('img/banner'), $tConfiguration->idConfiguration.'-banner01.'.$fileBackgroundBannerOneExtension);
				}

				if($request->hasFile('fileBackgroundBannerTwo'))
				{
					$request->file('fileBackgroundBannerTwo')->move(public_path('img/banner'), $tConfiguration->idConfiguration.'-banner02.'.$fileBackgroundBannerTwoExtension);
				}

				if($request->hasFile('fileBackgroundBannerThree'))
				{
					$request->file('fileBackgroundBannerThree')->move(public_path('img/banner'), $tConfiguration->idConfiguration.'-banner03.'.$fileBackgroundBannerThreeExtension);
				}

				DB::commit();

				return PlatformHelper::redirectCorrect(['Operación realizada correctamente.'], 'configuration/management');
			}
			catch(\Exception $e)
			{
				DB::rollBack();

				return PlatformHelper::catchException(__CLASS__, __FUNCTION__, $e->getMessage(), '/');
			}
		}

		return view('configuration/management');
	}
}
?>