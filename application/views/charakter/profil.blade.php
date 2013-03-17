@layout('template')


@section('content')
<h1>{{ $charakter->name }}</h1>
<section id="toc">
<ul class="nav nav-list">
	<li class="nav-header">Inhalt</li>
	<li><a href="#ueberblick">Überblick</a></li>
	<li><a href="#notizen">Notizen</a></li>
	<li><a href="#missionen">Missionen</a></li>
</ul>

</section>

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

<section id="notizen">
	<h2>Notizen</h2>
	@if($ncount > 1)
	<div class="tabbable tabs-right">
		@if($ncount > 4)
		<ul class="nav nav-tabs">
			<?php for($n = 1; $n < ($ncount / 4) + 1; $n++): ?>
			<li <?php if($n == 1) echo 'class="active"'; ?>><a href="#n{{ $n }}" data-toggle="tab">{{ $n }}</a></li>
			<?php endfor; ?>
		</ul>
		@endif
		<div class="tab-content">
			<?php $i = 0; $k = 1; ?>
			@foreach($notizen as $n)
				@if($i == 0)
			<div class="tab-pane active" id='n1'>
				@endif
				@if($i > 4)
			<div class="tab-pane" id='n{{ $k }}'>
				@endif
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
				<?php $i++; ?>
				@if($i == 0 || $i > 4)
			</div>
					<?php $i = 1; $k++; ?>
				@endif
			@endforeach
		</div>
	</div>
	@endif
</section>

<section id="missionen">
	<h2>Missionen</h2>
</section>

<!--
<section>
<h2>Debug</h2>
<pre class="pre-scrollable">
{{ var_dump($charakter) }}
</pre>
</section>-->

@endsection