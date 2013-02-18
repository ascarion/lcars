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
					{{ Form::open('login') }}
						<fieldset>
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend">
										<span class="add-on"><i class="icon-user"></i></span>
										<input type="text" placeholder="Spieler" name="iSpieler">
									</div>
								</div>
							</div>
							<div class="control-group">
								<div class="controls">
									<div class="input-prepend">
										<span class="add-on"><i class="icon-lock"></i></span>
										<input type="password" placeholder="Passwort" name="iPassword">
									</div>
								</div>
							</div>
								@if(Session::has('login_errors')) 
									<div class="alert alert-error">
										<button type="button" class="close" data-dismiss="alert">&times;</button>
										Login-Daten fehlerhaft.
									</div>
								@endif
							<div class="control-group">
								<div class="controls">
									<button class="btn btn-primary" type="submit">Anmelden</button>
								</div>
							</div>
							{{ HTML::link('forgot-password', 'Passwort vergessen')}}
						</fieldset>
					{{ Form::close() }}
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