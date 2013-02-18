@layout('errors')

@section('content')
	<h1>Error 404</h1>

	<p>Die gewünschte Seite konnte leider nicht gefunden werden. Das tut uns leid.</p>
	<p>{{ HTML::link('/', 'Zurück zur Hauptseite')}}</p>
@endsection