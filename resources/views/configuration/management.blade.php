@extends('template.layout')
@section('title', 'Configuración general')
@section('generalBody')
<div class="nav-tabs-custom">
	<div class="tab-content">
		<form id="frmManagementConfiguration" action="{{url('configuration/management')}}" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="form-group col-md-6">
					<label for="txtPlatformName">Nombre plataforma</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtPlatformName" name="txtPlatformName" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformName : null}}">
					</div>
				</div>
				<div class="form-group col-md-6">
					<label for="txtPlatformTitle">Título plataforma</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtPlatformTitle" name="txtPlatformTitle" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->platformTitle : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-3">
					<label for="fileBlackLogo">Logo mat. obscuros {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->blackLogoExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileBlackLogo" name="fileBlackLogo" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
				<div class="form-group col-md-3">
					<label for="fileBlackLogoMinimal">Logo mín. mat. obs. {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->blackLogoMinimalExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileBlackLogoMinimal" name="fileBlackLogoMinimal" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
				<div class="form-group col-md-3">
					<label for="fileWhiteLogo">Logo mat. claros {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->whiteLogoExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileWhiteLogo" name="fileWhiteLogo" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
				<div class="form-group col-md-3">
					<label for="fileWhiteLogoMinimal">Logo mín. mat. cla. {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->whiteLogoMinimalExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileWhiteLogoMinimal" name="fileWhiteLogoMinimal" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-3">
					<label for="txtLinkedInUrl">URL LinkedIn</label>
					<input type="text" id="txtLinkedInUrl" name="txtLinkedInUrl" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->linkedInUrl : null}}">
				</div>
				<div class="form-group col-md-3">
					<label for="txtFacebookUrl">URL Facebook</label>
					<input type="text" id="txtFacebookUrl" name="txtFacebookUrl" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->facebookUrl : null}}">
				</div>
				<div class="form-group col-md-3">
					<label for="txtYouTubeUrl">URL YouTube</label>
					<input type="text" id="txtYouTubeUrl" name="txtYouTubeUrl" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->youTubeUrl : null}}">
				</div>
				<div class="form-group col-md-3">
					<label for="txtTwitterUrl">URL Twitter</label>
					<input type="text" id="txtTwitterUrl" name="txtTwitterUrl" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twitterUrl : null}}">
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtTextForPhone">Texto telf.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextForPhone" name="txtTextForPhone" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForPhone : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtPhone">Teléfono*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtPhone" name="txtPhone" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->phone : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtPhoneContact">Telf. contacto*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtPhoneContact" name="txtPhoneContact" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->phoneContact : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTextForAddress">Texto dir.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextForAddress" name="txtTextForAddress" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForAddress : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtAddress">Dirección*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtAddress" name="txtAddress" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->address : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtFullAddress">Dir. exacta*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtFullAddress" name="txtFullAddress" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->fullAddress : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtLatitudeMap">Latitude*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtLatitudeMap" name="txtLatitudeMap" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->latitudeMap : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtLongitudeMap">Longitude*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtLongitudeMap" name="txtLongitudeMap" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->longitudeMap : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtZoomMap">Zoom*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtZoomMap" name="txtZoomMap" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->zoomMap : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTextForDateText">Texto atenc.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextForDateText" name="txtTextForDateText" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textForDateText : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtDateText">Texto cerrado*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtDateText" name="txtDateText" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->dateText : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtContactEmail">Correo cont.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtContactEmail" name="txtContactEmail" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->contactEmail : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtFooterYear">Año ©*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtFooterYear" name="txtFooterYear" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerYear : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtFooterText">Texto ©</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtFooterText" name="txtFooterText" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerText : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtFooterUrl">URL texto ©</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtFooterUrl" name="txtFooterUrl" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->footerUrl : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtUrlForEmail">URL email*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtUrlForEmail" name="txtUrlForEmail" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlForEmail : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtApiKeyGoogleMaps">Key Maps*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtApiKeyGoogleMaps" name="txtApiKeyGoogleMaps" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->apiKeyGoogleMaps : null}}">
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtOneDescriptionBannerOne">B1 Desc. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtOneDescriptionBannerOne" name="txtOneDescriptionBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTwoDescriptionBannerOne">B1 Desc. 2*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTwoDescriptionBannerOne" name="txtTwoDescriptionBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlCentralDescriptionBannerOne">B1 Desc. H.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlCentralDescriptionBannerOne" name="txtHtmlCentralDescriptionBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtUrlBannerOne">B1 URL</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtUrlBannerOne" name="txtUrlBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTextUrlBannerOne">B1 Texto URL 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextUrlBannerOne" name="txtTextUrlBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textUrlBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlOneFooterBannerOne">B1 F. H. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlOneFooterBannerOne" name="txtHtmlOneFooterBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlOneFooterBannerOne : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtHtmlTwoFooterBannerOne">B1 F. H. 2</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlTwoFooterBannerOne" name="txtHtmlTwoFooterBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlTwoFooterBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlThreeFooterBannerOne">B1 F. H. 3</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlThreeFooterBannerOne" name="txtHtmlThreeFooterBannerOne" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlThreeFooterBannerOne : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="fileBackgroundBannerOne">B1 Imagen {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerOneExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileBackgroundBannerOne" name="fileBackgroundBannerOne" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtOneDescriptionBannerTwo">B2 Desc. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtOneDescriptionBannerTwo" name="txtOneDescriptionBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTwoDescriptionBannerTwo">B2 Desc. 2*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTwoDescriptionBannerTwo" name="txtTwoDescriptionBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlCentralDescriptionBannerTwo">B2 Desc. H.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlCentralDescriptionBannerTwo" name="txtHtmlCentralDescriptionBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtUrlBannerTwo">B2 URL</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtUrlBannerTwo" name="txtUrlBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTextUrlBannerTwo">B2 Texto URL 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextUrlBannerTwo" name="txtTextUrlBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textUrlBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlOneFooterBannerTwo">B2 F. H. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlOneFooterBannerTwo" name="txtHtmlOneFooterBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlOneFooterBannerTwo : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtHtmlTwoFooterBannerTwo">B2 F. H. 2</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlTwoFooterBannerTwo" name="txtHtmlTwoFooterBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlTwoFooterBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlThreeFooterBannerTwo">B2 F. H. 3</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlThreeFooterBannerTwo" name="txtHtmlThreeFooterBannerTwo" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlThreeFooterBannerTwo : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="fileBackgroundBannerTwo">B2 Imagen {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerTwoExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileBackgroundBannerTwo" name="fileBackgroundBannerTwo" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtOneDescriptionBannerThree">B3 Desc. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtOneDescriptionBannerThree" name="txtOneDescriptionBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTwoDescriptionBannerThree">B3 Desc. 2*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTwoDescriptionBannerThree" name="txtTwoDescriptionBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlCentralDescriptionBannerThree">B3 Desc. H.*</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlCentralDescriptionBannerThree" name="txtHtmlCentralDescriptionBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtUrlBannerThree">B3 URL</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtUrlBannerThree" name="txtUrlBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->urlBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtTextUrlBannerThree">B3 Texto URL 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtTextUrlBannerThree" name="txtTextUrlBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->textUrlBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlOneFooterBannerThree">B3 F. H. 1</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlOneFooterBannerThree" name="txtHtmlOneFooterBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlOneFooterBannerThree : null}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-md-2">
					<label for="txtHtmlTwoFooterBannerThree">B3 F. H. 2</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlTwoFooterBannerThree" name="txtHtmlTwoFooterBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlTwoFooterBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="txtHtmlThreeFooterBannerThree">B3 F. H. 3</label>
					<div class="input-group">
						<div class="input-group-addon">
							<i class="fa fa-i-cursor"></i>
						</div>
						<input type="text" id="txtHtmlThreeFooterBannerThree" name="txtHtmlThreeFooterBannerThree" class="form-control" value="{{$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlThreeFooterBannerThree : null}}">
					</div>
				</div>
				<div class="form-group col-md-2">
					<label for="fileBackgroundBannerThree">B3 Imagen {!!($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerThreeExtension!='') ? '<i class="fa fa-paperclip"></i>' : ''!!}</label>
					<input type="file" id="fileBackgroundBannerThree" name="fileBackgroundBannerThree" class="form-control" accept="image/png,image/jpg,image/jpeg">
				</div>
			</div>
			<hr>
			<div class="row">
				{!!csrf_field()!!}
				<div class="col-md-12 text-right">
					<input type="button" class="btn btn-primary" value="Guardar cambios realizados" onclick="sendFrmManagementConfiguration();">
				</div>
			</div>
		</form>
	</div>
</div>
@endsection
@section('jsSection')
<script src="{{asset('viewResources/configuration/management.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection