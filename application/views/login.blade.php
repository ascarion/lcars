@layout('template')

@section('styles')
	<style type="text/css">
		.container > .content {
			background-color: #000;
			padding: 20px;
			margin: 0 -20px;
			border-radius: 10px 10px 10px 10px;
			box-shadow: 0 1px 2px rgba(0,0,0,.15);
		}

		#content {
			width: 350px;
		}

		.login-form {
			margin-left: 65px;
		}
	</style>
@endsection

@section('content')
	<div class="container" id="content" style="margin-top: 40px">
		<div class="content">
			<div class="row">
				<div class="login-form">
					<h2>Login</h2>
					<form action="" >
						<fieldset>
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend">
										<span class="add-on"><i class="icon-user"></i></span>
										<input type="text" placeholder="Spieler" id="iSpieler">
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend">
										<span class="add-on"><i class="icon-lock"></i></span>
										<input type="password" placeholder="Passwort" id="iPassword">
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<label>
										<input type="checkbox" id="iCookie"> Angemeldet bleiben
									</label>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<button class="btn btn-primary" type="submit">Anmelden</button>
								</div>
							</div>
							{{ HTML::link('forgot-password', 'Passwort vergessen')}}
						</fieldset>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('title')
Login
@endsection

@section('topnav')
@endsection

@section('account')
Login
@endsection