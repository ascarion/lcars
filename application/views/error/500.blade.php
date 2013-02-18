@layout('errors')

@section('content')
	<h1>Error 500</h1>

	<p>Irgendetwas läuft schief. Wenn der Fehler häufiger auftritt, kontaktiere einen Administrator.</p>
	<p>{{ HTML::link('/', 'Zurück zur Hauptseite')}}</p>
@endsection