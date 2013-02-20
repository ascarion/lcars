@layout('template')


@section('content')
<h1>{{ $charakter->name }}</h1>
<section id="ueberblick">
	<h2>Überblick</h2>
	<table class="table">
		<tbody>
		<tr>
			<th>Rang</th>
			<td>{{ $charakter->rang->name }}</td>
		</tr>
		<tr>
			<th>Position</th>
			<td>{{ $charakter->position->name }}</td>
		</tr>
		<tr>
			<th>Komponente</th>
			<td>{{ $charakter->position->komponente->name }} 
				<span class="annotation">{{ $charakter->position->komponente->typ }}</span></td>
		</tr>
		<tr>
			<th>Status</th>
			<td>
				@if($charakter->aktiv)
					<span class="label label-success">Aktiv</span>
				@else
					<span class="label label-important">Inaktiv</span>
				@endif
				@if($charakter->hauptcharakter) 
					<i class="icon-ok icon-white"></i> Hauptcharakter
				@else
					Nebencharakter
				@endif
		</tr>
		<tr>
			<th>Pins</th>
			<td>
				{{ Schnipsel::pinicon('missionspins', $charakter->missionspins) }}
				&nbsp;&nbsp;{{ Schnipsel::pinicon('leiterpins', $charakter->leiterpins) }}
				&nbsp;&nbsp;{{ Schnipsel::pinicon('gastpins', $charakter->gastpins) }}
			</td>
		</tr>
		<tr>
			<th>Spieler</th>
			<td>{{ HTML::link_to_action('spieler@profil', $charakter->spieler->name, array($charakter->spieler->id)) }}
		</tr>
		<tr>
			<th>Erstellt</th>
			<td>{{ Schnipsel::datumsformat($charakter->created_at) }}</td>
		</tr>
		<tr>
			<th>Letztes Update</th>
			<td>{{ Schnipsel::datumsformat($charakter->updated_at) }}</td>
		</tr>
		</tbody>
	</table>
</section>


<section>
<h2>Debug</h2>
<pre class="pre-scrollable">
{{ var_dump($charakter) }}
</pre>
</section>

@endsection