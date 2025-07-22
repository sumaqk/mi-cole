@extends('template.layoutpublic')
@section('generalBody')
<div class="paddingLayoutBodyInternal">
	<div class="row">
		<div class="col-md-12">
			@if(isset($confirmation) && $confirmation!=null)
				<div class="alert alert-dismissible">
					<h4><i class="icon fa fa-info"></i> Aviso importante!</h4>
					Gracias por confirmar tu registro, ahora puedes iniciar sesión en la plataforma.
				</div>
			@else
				<div class="alert alert-dismissible">
					<h4><i class="icon fa fa-warning"></i> Aviso importante!</h4>
					Se le ha enviado un enlace a su correo para que pueda confirmar su registro. Por favor revise su cuenta de correo; si no encuentra el mensaje en su bandeja principal, revise entre su bandeja de spam.
				</div>
			@endif
		</div>
	</div>
</div>
@endsection