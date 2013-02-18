<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>LCARS - Fehler</title>
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