@extends('layout')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Login</div>

				<div class="panel-body">
					<div class="col-lg-12">
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
							<label>Email:</label>
							<br>
							<input type="text" id="email">
							<br>
							<label>Contraseña:</label>
							<br>
							<input type="password" id="pass">
							<br>
							<br>
							<button id="ingresar" class="btn btn-info">Ingresar</button>
						</div>
						<div class="col-lg-4"></div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	{!! Html::script('js-script/login.js') !!}
	<!--<script type="text/javascript" src="{{asset('js-script/home.js')}}"</script>-->
</div>
@endsection