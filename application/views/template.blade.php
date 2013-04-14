<!DOCTYPE html>
<html lang="de">
<head>
	<meta charset="utf-8">
	<title>LCARS - {{ $title }}</title>
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
					<li>{{ HTML::link('spieler', 'Spieler') }}</li>
					<li>{{ HTML::link('charakter', 'Charaktere') }}</li>
					<li><a href="#">Komponenten</a></li>
					<li><a href="#">Sternenkarte</a></li>
					@yield_section
				</ul>
				<ul class="nav pull-right">
						<li><a href="http://stardate.trekzone.de"><i class="icon-star icon-white"></i> {{ Datum::createFromTimestamp()->toInplay()->toSternzeit()->getSternzeit() }}</a></li>
					@if(!is_null(Auth::user()))
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">{{ Auth::user()->name }} <b class="caret"></b></a>
							<ul class="dropdown-menu">
								@yield('topnav_user')
								<li>{{ HTML::link_to_action('spieler@profil', 'Spielerprofil', array(Auth::user()->id)) }}</li>
								<li><a href="#">Passwort &amp; Email ändern</a></li>
								<li class="divider"></li>
								<li>{{ HTML::link_to_route('logout', 'Abmelden') }}</li>
							</ul>
						</li>	
					@else
						<li>{{ HTML::link_to_route('login', 'Login') }}</li>	
					@endif
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