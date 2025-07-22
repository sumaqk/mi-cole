<link rel="stylesheet" href="{{asset('viewResources/template/parcial/layoutpublic/banner.css?x='.config('var.CACHE_LAST_UPDATE'))}}">
<div class="divPrincipalBanner divPrincipalBannerOne divPrincipalBannerActive" style="{{($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerOneExtension!='') ? 'background-image: url("'.asset('img/banner/'.$tConfigurationFmMdl->idConfiguration.'-banner01.'.$tConfigurationFmMdl->backgroundBannerOneExtension).'?x='.ViewHelper::dateToCache($tConfigurationFmMdl->updated_at).'");background-size: 100% auto;' : ''}}">
	<div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerOne : 'Sea bienvenido a nuestra plataforma'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerOne : 'Accede a nuestros servicios y saca el provecho máximo'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerOne : 'Plataforma que brinda grandes beneficios'!!}</div>
		@if($tConfigurationFmMdl!=null && trim($tConfigurationFmMdl->urlBannerOne)!='' && trim($tConfigurationFmMdl->textUrlBannerOne)!='')
			<div class="divPrincipalBannerButton"><a href="{{$tConfigurationFmMdl->urlBannerOne}}">{{$tConfigurationFmMdl->textUrlBannerOne}}</a></div>
		@endif
		@if($tConfigurationFmMdl!=null && (trim($tConfigurationFmMdl->htmlOneFooterBannerOne)!='' || trim($tConfigurationFmMdl->htmlTwoFooterBannerOne)!='' || trim($tConfigurationFmMdl->htmlThreeFooterBannerOne)!=''))
			<div class="divPrincipalBannerFooterItems">
				<div>
					@if(trim($tConfigurationFmMdl->htmlOneFooterBannerOne)!='')
						{!!$tConfigurationFmMdl->htmlOneFooterBannerOne!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlTwoFooterBannerOne)!='')
						{!!$tConfigurationFmMdl->htmlTwoFooterBannerOne!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlThreeFooterBannerOne)!='')
						{!!$tConfigurationFmMdl->htmlThreeFooterBannerOne!!}
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
<div class="divPrincipalBanner divPrincipalBannerTwo" style="{{($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerTwoExtension!='') ? 'background-image: url("'.asset('img/banner/'.$tConfigurationFmMdl->idConfiguration.'-banner02.'.$tConfigurationFmMdl->backgroundBannerTwoExtension).'?x='.ViewHelper::dateToCache($tConfigurationFmMdl->updated_at).'");background-size: 100% auto;' : ''}}">
	<div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerTwo : 'Sea bienvenido a nuestra plataforma'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerTwo : 'Accede a nuestros servicios y saca el provecho máximo'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerTwo : 'Plataforma que brinda grandes beneficios'!!}</div>
		@if($tConfigurationFmMdl!=null && trim($tConfigurationFmMdl->urlBannerTwo)!='' && trim($tConfigurationFmMdl->textUrlBannerTwo)!='')
			<div class="divPrincipalBannerButton"><a href="{{$tConfigurationFmMdl->urlBannerTwo}}">{{$tConfigurationFmMdl->textUrlBannerTwo}}</a></div>
		@endif
		@if($tConfigurationFmMdl!=null && (trim($tConfigurationFmMdl->htmlOneFooterBannerTwo)!='' || trim($tConfigurationFmMdl->htmlTwoFooterBannerTwo)!='' || trim($tConfigurationFmMdl->htmlThreeFooterBannerTwo)!=''))
			<div class="divPrincipalBannerFooterItems">
				<div>
					@if(trim($tConfigurationFmMdl->htmlOneFooterBannerTwo)!='')
						{!!$tConfigurationFmMdl->htmlOneFooterBannerTwo!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlTwoFooterBannerTwo)!='')
						{!!$tConfigurationFmMdl->htmlTwoFooterBannerTwo!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlThreeFooterBannerTwo)!='')
						{!!$tConfigurationFmMdl->htmlThreeFooterBannerTwo!!}
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
<div class="divPrincipalBanner divPrincipalBannerThree" style="{{($tConfigurationFmMdl!=null && $tConfigurationFmMdl->backgroundBannerThreeExtension!='') ? 'background-image: url("'.asset('img/banner/'.$tConfigurationFmMdl->idConfiguration.'-banner03.'.$tConfigurationFmMdl->backgroundBannerThreeExtension).'?x='.ViewHelper::dateToCache($tConfigurationFmMdl->updated_at).'");background-size: 100% auto;' : ''}}">
	<div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->oneDescriptionBannerThree : 'Sea bienvenido a nuestra plataforma'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->htmlCentralDescriptionBannerThree : 'Accede a nuestros servicios y saca el provecho máximo'!!}</div>
		<div>{!!$tConfigurationFmMdl!=null ? $tConfigurationFmMdl->twoDescriptionBannerThree : 'Plataforma que brinda grandes beneficios'!!}</div>
		@if($tConfigurationFmMdl!=null && trim($tConfigurationFmMdl->urlBannerThree)!='' && trim($tConfigurationFmMdl->textUrlBannerThree)!='')
			<div class="divPrincipalBannerButton"><a href="{{$tConfigurationFmMdl->urlBannerThree}}">{{$tConfigurationFmMdl->textUrlBannerThree}}</a></div>
		@endif
		@if($tConfigurationFmMdl!=null && (trim($tConfigurationFmMdl->htmlOneFooterBannerThree)!='' || trim($tConfigurationFmMdl->htmlTwoFooterBannerThree)!='' || trim($tConfigurationFmMdl->htmlThreeFooterBannerThree)!=''))
			<div class="divPrincipalBannerFooterItems">
				<div>
					@if(trim($tConfigurationFmMdl->htmlOneFooterBannerThree)!='')
						{!!$tConfigurationFmMdl->htmlOneFooterBannerThree!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlTwoFooterBannerThree)!='')
						{!!$tConfigurationFmMdl->htmlTwoFooterBannerThree!!}
					@endif
				</div>

				<div>
					@if(trim($tConfigurationFmMdl->htmlThreeFooterBannerThree)!='')
						{!!$tConfigurationFmMdl->htmlThreeFooterBannerThree!!}
					@endif
				</div>
			</div>
		@endif
	</div>
</div>
@section('jsSection')
<script src="{{asset('viewResources/template/parcial/layoutpublic/banner.js?x='.config('var.CACHE_LAST_UPDATE'))}}"></script>
@endsection