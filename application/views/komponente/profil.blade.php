@layout('template')

@section('content')
<h1>{{ $komponente->name }}</h1>
<section id="ueberblick">
	<h2>Überblick</h2>
	<table class="table">
		<tr>
			<th>ID</th>
			<td>{{ $komponente->id }}</td>
		</tr>
		<tr>
			<th>Typ</th>
			<td>
				{{ $komponente->typ }}
			</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>
				@if($komponente->aktiv)
					<span class="label label-success">Aktiv</span>
				@else
					<span class="label label-important">Inaktiv</span>
				@endif
			</td>
		</tr>
		<tr>
			<th>Pins per Mission</th>
			<td>
					{{ Schnipsel::pinicon('missionspins', $komponente->missionspins) }}
					{{ Schnipsel::pinicon('leiterpins', $komponente->leiterpins) }}
					{{ Schnipsel::pinicon('gastpins', $komponente->gastpins) }}
			</td>
		</tr>
		<tr>
			<th>Erstellt</th>
			<td>{{ Schnipsel::datumsformat($komponente->created_at) }}</td>
		</tr>
		<tr>
			<th>Letztes Update</th>
			<td>{{ Schnipsel::datumsformat($komponente->updated_at) }}</td>
		</tr>
	</table>
</section>

<section>
	<h2>Charaktere</h2>

	<table class="table table-hover">
		<thead>
			<tr>
				<th>Name</th>
				<th>Rang</th>
				<th>Position</th>
				<th colspan="3">Pins</th>
			</tr>
		</thead>
		<tbody>
		@foreach($charaktere as $charakter) 
			<tr>
				<td>{{ HTML::link_to_action('charakter@profil', $charakter->name, array($charakter->id)) }}</td>
				<td>{{ $charakter->rang->name }}</td>
				<td>{{ $charakter->position->name }}</td>
				<td>{{ Schnipsel::pinicon('missionspins', $charakter->missionspins) }}</td>
				  <td>{{ Schnipsel::pinicon('leiterpins', $charakter->leiterpins) }}</td>
				  <td>{{ Schnipsel::pinicon('gastpins', $charakter->gastpins) }}</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</section>

<section id="missionen">
	<h2>Missionen</h2>
	<div id="missionenliste">
		@foreach($missionen as $mission)
		<div>{{ HTML::link_to_action('ajax@mission', Schnipsel::datumsformat($mission->created_at, "d.m.Y"), array($mission->id)) }}</div>
		@endforeach
	</div>
</section>
@endsection
