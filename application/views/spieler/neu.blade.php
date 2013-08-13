@layout('template')

@section('content') 
<h1>Spieler Hinzuf&uuml;gen</h1>
<section>
	{{Form::open('spieler/neu', 'POST', array('class' => 'form'))}}
	<h2>Spieler</h2>
	<table class="table"><tbody>
		<tr>
			<td>Vor- und Nachname</td>
			<td>
				<div class="input-prepend">
					<span class="add-on"><i class="icon-user"></i></span>
					<input type="text" name="name" placeholder="Vor- und Nachname">
				</div>
			</td>
		</tr>
		<tr>
			<td>Email-Addresse</td>
			<td>
				<div class="input-prepend">
					<span class="add-on">@</span>
					<input type="email" name="email" placeholder="Email">
				</div>
			</td>
		</tr>
		<tr>
			<td>Status</td>
			<td>
				<label class="radio">
					<input type="radio" name="spieler-aktiv" value="1" id="spieler-aktiv1" checked>
					<span class="label label-success">Aktiv</span>
				</label>
				<label class="radio">
					<input type="radio" name="spieler-aktiv" value="0" id="spieler-aktiv2">
					<span class="label label-important">Inaktiv</span>
				</label>
			</td>
		<tr>
		<tr>
			<td>Rolle</td>
			<td>((Rollenselector))</td>
		</tr>
		<tr>
			<td>Charakter anlegen</td>
			<td>
				<label class="checkbox">
					<input type="checkbox" name="charakter-anlegen" data-toggle="collapse" data-target="#charakter" value="1">
					Charakter zusammen mit Spieler anlegen.
				</label>
			</td>
		</tr>
	</tbody></table>

	<div id="charakter" class="collapse">
		<h2>Charakter</h2>
		<table class="table"><tbody>
			<tr>
				<td>Vor-und Nachname</td>
				<td>
					<label class="checkbox">
					<input type="checkbox" name="char-spielername" data-toggle="collapse" data-target="#char-name" value="1" checked>
					Spielername übernehmen.
				</label>
					<div class="input-prepend collapse" id="char-name">
						<span class="add-on"><i class="icon-user"></i></span>
						<input type="text" name="char-name" placeholder="Vor- und Nachname">
					</div>
				</td>
			</tr>
			<tr>
				<td>Rang</td>
				<td>
					<input type="text" name="char-rang" id="char-rang">
					<input type="hidden" value="0" name="char-rang-id" id="char-rang-id">
				</td>
			</tr>
			<tr>
				<td>Position</td>
				<td>
					<input type="hidden" value="0" name="char-position-id" id="char-position-id">
					<span id="char-position-text"></span>
					<button class="btn" data-toggle="modal" data-target="#position-popup">Position setzen</button>
				</td>
			</tr>
			<tr>
				<td>Status</td>
				<td>
					<label class="radio">
						<input type="radio" name="char-aktiv" value="1" id="spieler-aktiv1" checked>
						<span class="label label-success">Aktiv</span>
					</label>
					<label class="radio">
						<input type="radio" name="char-aktiv" value="0" id="spieler-aktiv2">
						<span class="label label-important">Inaktiv</span>
					</label>
				</td>
			</tr>
		</tbody></table>
	</div>
	<input type="submit" class="btn btn-primary" value="Spieler hinzufügen">
	
	{{Form::close()}}


</section>


<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="mLabel" aria-hidden="true" id="position-popup">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3>Position festlegen</h3>
	</div>
	<div class="modal-body">
		Komponente<br>
		Position
	</div>
	<div class="modal-footer">
		<button class="btn" data-dismiss="modal" aria-hidden="true">Abbrechen</button>
		<button class="btn btn-primary">OK</button>
	</div>
</div>
@endsection

@section('scripts')
{{ Asset::container('neu')->scripts(); }}
@endsection