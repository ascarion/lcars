@layout('template')

@section('content')
<h1>Komponenten</h1>

<p>Die Datenbank enthält <strong>{{ $no }}</strong> Komponenten.</p>


{{ $komponenten->links() }}

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Typ</th>
			<th>Aktiv</th>
		</tr>	
	</thead>	
	<tbody>
		@foreach($komponenten->results as $kp)
			<tr>
				<td>{{$kp->id}}</td>
				<td>{{ HTML::link_to_action('komponente@profil', $kp->name, array($kp->id)) }}</td>
				<td>{{$kp->typ}}</td>
				<td>
					@if($kp->aktiv)
						<span class="label label-success">Aktiv</span>
					@else
						<span class="label label-important">Inaktiv</span>
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

{{ $komponenten->links() }}


@endsection