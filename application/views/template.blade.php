<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title> LCARS - {{ $title }}</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	{{ Asset::styles(); }}
	{{ Asset::container('bootstrap')->styles(); }}
	@yield('styles')
</head>
<body>
<div id="wrap">
	<div class="navbar navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
				{{ HTML::link('/', 'LCARS', array('class' => 'brand')) }}
				<ul class="nav">
					@section('topnav')
					<li><a href="#">Spieler</a></li>
					<li><a href="#">Charaktere</a></li>
					<li><a href="#">Komponenten</a></li>
					<li><a href="#">Sternenkarte</a></li>
					<li><a href="#">Administration</a></li>
					@yield_section
				</ul>
				<ul class="nav pull-right">
					<li><a href="#">@yield('account')</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container" id="content">
		@yield('content')
	</div>
	<div id="push"></div>
</div>
	<footer id="footer">
		<div class="container">
			<hr>
			<p class="muted">&copy; 2013 - Trekzone Network Rollenspiel</p>
		</div>
	</footer>
	{{ Asset::scripts(); }}
	{{ Asset::container('bootstrap')->scripts(); }}
	@yield('scripts')
</body>
</html>