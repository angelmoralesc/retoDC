<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Reto Digital Coaster</title>

	{!! Html::style('assets/css/bootstrap.css') !!}
	{!! Html::script('js/jquery-3.1.1.min.js') !!}
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	<script>
		var BASEURL = {!! json_encode(url('/')) !!};
	</script>

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header col-lg-12">
				<div class="col-lg-2">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle Navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">Reto Digital Coaster</a>
				</div>
				<div class="col-lg-8"></div>
				<div class="col-lg-2">
					@yield('logout')
				</div>
				
			</div>

			
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	{!! Html::script('assets/js/bootstrap.min.js') !!}
	{!! Html::script('js/jquery-3.1.1.min.js') !!}
</body>
</html>