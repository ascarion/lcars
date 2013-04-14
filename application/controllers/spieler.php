<?php

class Spieler_Controller extends Base_Controller {

	public function action_index() {
		return Redirect::to_action('spieler@liste');
	}

	public function action_profil($id) {
		$spieler = Spieler::find($id);
		
		if($id == 0 || is_null($spieler)) {
			return Response::error('404');
		}

		$charaktere = $spieler
			->charaktere()
			->with(array('position','rang'))
			->order_by('aktiv', 'desc')
			->get();


		$notizen = array();
		$pins = array();
		$pins['mp'] = $pins['lp'] = $pins['gp'] = 0;

		foreach ($charaktere as $charakter) {
			$notizen[$charakter->name] = $charakter->notizen()->order_by('updated_at', 'desc')->get();
			$pins['mp'] += $charakter->missionspins;
			$pins['lp'] += $charakter->leiterpins;
			$pins['gp'] += $charakter->gastpins;
		}

		$notizen['Eigene Beiträge'] = Notiz::with(array('charakter', 'autor', 'editierer'))
			->where('eintragende_id', '=', $spieler->id)
			->or_where('aendernde_id', '=', $spieler->id)->order_by('updated_at', 'desc')->get();

		return View::make('spieler.profil')
			->with('title', "Spieler - " . $spieler->name)
			->with('spieler', $spieler)
			->with('charaktere', $charaktere)
			->with('notizen', $notizen)
			->with('pins', $pins)
			->with('admin', true);
	}

	public function action_liste() {
		$spieler = Spieler::paginate();
		$no = Spieler::count();
		return View::make('spieler.liste')
			->with('spieler', $spieler)
			->with('no', $no)
			->with('title', 'Spielerliste');

	}
}