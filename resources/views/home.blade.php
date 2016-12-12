@extends('layout')

@section('logout')
<a class="navbar-brand" href="{{url('/')}}"><span class="glyphicon glyphicon-log-out fa-2x" arial-hidden="true"></span>&nbsp;Salir</a>
@endsection

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body">
					<div class="col-lg-12">
						<div class="col-lg-6">
							<label>Ultimo usuario agregado</label>
							<br>
							<label>Nombre: </label><span id="username"></span>
							<br>
							<label>Email: </label><span id="usermail"></span>
						</div>
						<div class="col-lg-6">
							<label>Nombre:</label>
							<br>
							<input type="text" id="name">
							<br>
							<label>Email:</label>
							<br>
							<input type="text" id="email">
							<br>
							<label>Contraseña:</label>
							<br>
							<input type="password" id="pass">
							<br>
							<label>Confirmar contraseña:</label>
							<br>
							<input type="password" id="pass2">
							<br>
							<br>
							<button id="registrar" class="btn btn-info">Registrar</button>
						</div>
						
					</div>
					
				</div>
			</div>
		</div>
	</div>
	{!! Html::script('js-script/home.js') !!}
	<!--<script type="text/javascript" src="{{asset('js-script/home.js')}}"</script>-->
</div>
@endsection