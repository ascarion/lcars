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
				<td>{{ HTML::link_to_action('spieler@profil', $sp->name, array($sp->id)) }}</td>
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

<!--@if(Auth::user()->admin)-->
<div id="addform">
	<?php $msgs = $errors->all() ?>
	@foreach($msgs as $e)
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Fehler!</strong>	{{$e}}
		</div>
	@endforeach
	{{Form::open('spieler/neu', 'POST', array('class' => 'form-inline'))}}
	<fieldset>
		<div class="input-prepend">
			<span class="add-on"><i class="icon-user"></i></span>
			<input type="text" name="name" placeholder="Vor- und Nachname">
		</div>
		<div class="input-prepend">
			<span class="add-on">@</span>
			<input type="email" name="email" placeholder="Email">
		</div>
		<input type="submit" class="btn btn-primary" value="Spieler hinzufügen">
	</fieldset>
	{{Form::close()}}
</div>
<!--@endif-->

@endsection