@layout('template')

@section('content')
<h1>Spieler</h1>

<p>Die Datenbank enthält <strong>{{ $no }}</strong> Spieler.</p>


{{ $spieler->links() }}

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Email</th>
			<th>Aktiv</th>
			<th>Admin</th>
		</tr>	
	</thead>	
	<tbody>
		@foreach($spieler->results as $sp)
			<tr>
				<td>{{$sp->id}}</td>
				<td>{{ HTML::link_to_action('spieler@profil', $sp->name, array($sp->id))}}</td>
				<td>{{$sp->email}}</td>
				<td>
					@if($sp->aktiv)
						<span class="label label-success">Aktiv</span>
					@else
						<span class="label label-important">Inaktiv</span>
					@endif
				</td>
				<td>
					@if(is_null($sp->rolle))
						<span class="label label-important">
							<i class="icon-ban-circle icon-white"></i></span>
					@else
						not done yet.
					@endif
			</tr>
		@endforeach
	</tbody>
</table>

{{ $spieler->links() }}


@endsection