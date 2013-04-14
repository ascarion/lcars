@layout('template')

@section('content')
<h1>{{ $spieler->name }}</h1>
<section id="ueberblick">
	<h2>Überblick</h2>
	<table class="table">
		<tr>
			<th>ID</th>
			<td>{{ $spieler->id }}</td>
		</tr>
		<tr>
			<th>Email</th>
			<td>
				{{ $spieler->email }}
				@if($admin)
					{{ Schnipsel::editbtn('emailbtn') }}
				@endif
			</td>
		</tr>
		<tr>
			<th>Status</th>
			<td>
				@if($spieler->aktiv)
					<span class="label label-success">Aktiv</span>
				@else
					<span class="label label-important">Inaktiv</span>
				@endif
				@if($admin)
					{{ Schnipsel::editbtn('aktivbtn') }}
				@endif
			</td>
		</tr>
		<tr>
			<th>Pins</th>
			<td>
				{{ Schnipsel::pinicon('missionspins', $pins['mp']) }}
				&nbsp;&nbsp;{{ Schnipsel::pinicon('leiterpins', $pins['lp']) }}
				&nbsp;&nbsp;{{ Schnipsel::pinicon('gastpins', $pins['gp']) }}
			</td>
		</tr>
		<tr>
			<th>Erstellt</th>
			<td>{{ Schnipsel::datumsformat($spieler->created_at) }}</td>
		</tr>
		<tr>
			<th>Letztes Update</th>
			<td>{{ Schnipsel::datumsformat($spieler->updated_at) }}</td>
		</tr>
		<tr>
			<th>Admin</th>
			@if(is_null($spieler->rolle))
				<td><span class="label label-important">
					<i class="icon-ban-circle icon-white"></i></span>
					@if($admin) 
						{{ Schnipsel::editbtn('adminbtn') }} 
					@endif
				</td>
			@else
				<td>
					not done yet.
					@if($admin) 
						{{ Schnipsel::editbtn('adminbtn') }} 
					@endif
				</td>
			@endif
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
				<th>Komponente</th>
				<th colspan="3">Pins</th>
				<th>Hauptcharakter</th>
			</tr>
		</thead>
		<tbody>
		@foreach($charaktere as $charakter) 
			<tr>
				<td>{{ HTML::link_to_action('charakter@profil', $charakter->name, array($charakter->id)) }}</td>
				<td>{{ $charakter->rang->name }}</td>
				<td>{{ $charakter->position->name }}</td>
				<td>{{ HTML::link_to_action('komponente@profil', $charakter->position->komponente->name, array($charakter->position->komponente->id)) }}</td>
				<td>{{ Schnipsel::pinicon('missionspins', $charakter->missionspins) }}</td>
				  <td>{{ Schnipsel::pinicon('leiterpins', $charakter->leiterpins) }}</td>
				  <td>{{ Schnipsel::pinicon('gastpins', $charakter->gastpins) }}</td>
				<td>
					@if($charakter->hauptcharakter)
						<i class="icon-ok icon-white" title="Hauptcharakter"></i>
					@else
						@if($admin)
							<button class="btn btn-mini" id="hc{{ $charakter->id }}" 
								title="{{$charakter->name}} zum Hauptcharakter machen.">
								<i class="icon-ok icon-white"></i>
							</button>
						@endif
					@endif
				</td>
			</tr>
		@endforeach
		</tbody>
	</table>
</section>

@if(count($notizen) > 0)
<section id="notizen">
<h2>Notizen</h2>
<div class="tabbable tabs-right">
	<ul class="nav nav-tabs">
	@foreach($notizen as $name => $notiz)
		@if($name == $charaktere[0]->name)
		<li class="active"><a href="#{{ Str::slug($name) }}" data-toggle="tab">{{ $name }}</a></li>
		@else
		<li><a href="#{{ Str::slug($name) }}" data-toggle="tab">{{ $name }}</a></li>
		@endif
	@endforeach
	</ul>
	<div class="tab-content">
		@foreach($notizen as $name => $notiz)
			@if($name == $charaktere[0]->name)
				<div class="tab-pane active" id="{{ Str::slug($name) }}">
			@else
				<div class="tab-pane" id="{{ Str:: slug($name) }}">
			@endif
				<?php foreach($notiz as $n) { ?>
					<div>
						<div class="well well-small">
							@if($admin)
								{{ Schnipsel::editbtn('n'.$n->id)}}
							@endif
							{{ Schnipsel::pinlabel('gastpins', $n->gastpins) }}
							{{ Schnipsel::pinlabel('leiterpins', $n->leiterpins) }}
							{{ Schnipsel::pinlabel('missionspins', $n->missionspins) }}
							<div>{{ $n->text }}</div>
							<div class="annotation">
								@if($name == 'Eigene Beiträge') 
									({{ $n->charakter->name }}) 
								@endif
								{{ HTML::link_to_action('spieler@profil', $n->autor->name, array($n->autor->id)) }} am {{ Schnipsel::datumsformat($n->created_at) }}. 
								@if($n->created_at != $n->updated_at)
									Zuletzt bearbeitet
										@if($n->autor->id != $n->editierer->id)
											von {{ HTML::link_to_action('spieler@profil', $n->editierer->name, array($n->editierer->id)) }} 
										@endif
									am {{ Schnipsel::datumsformat($n->updated_at) }}.
								@endif
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		@endforeach
	</div>
</div>
</section>
@endif


@endsection
