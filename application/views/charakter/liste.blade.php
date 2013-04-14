@layout('template')

@section('content')
<h1>Charaktere</h1>

<p>Die Datenbank enthält <strong>{{ $no }}</strong> Charaktere.</p>


{{ $charaktere->links() }}

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Rang</th>
			<th>Position</th>
			<th>Komponente</th>
			<th>Status</th>
		</tr>	
	</thead>	
	<tbody>
		@foreach($charaktere->results as $char)
			<tr>
				<td>{{$char->id}}</td>
				<td>{{ HTML::link_to_action('charakter@profil', $char->name, array($char->id)) }}</td>
				<td>{{$char->rang->name}}</td>
				<td>{{$char->position->name}}</td>
				<td>{{$char->position->komponente->name}}</td>
				<td>
					@if($char->aktiv)
						<span class="label label-success">Aktiv</span>
					@else
						<span class="label label-important">Inaktiv</span>
					@endif
					@if($char->hauptcharakter) 
						<i class="icon-ok icon-white"></i> Hauptcharakter
					@endif
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

{{ $charaktere->links() }}


@endsection