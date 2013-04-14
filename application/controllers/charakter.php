<?php

class Charakter_Controller extends Base_Controller {
	
	public function action_index() {
		return Redirect::to_action('charakter@liste');
	}

	public function action_profil($id) {
		$char = Charakter::find($id);
		$notizen = $char->notizen()->order_by('updated_at', 'desc')->get();
		$ncount = $char->notizen()->count();
		$missionen = Missionseintrag::where_charaktere_id($id)->order_by('id', 'desc')->get();

		$mcount[0] = Missionseintrag::where_charaktere_id($id)->where_anwesenheit(0)->count();
		$mcount[1] = Missionseintrag::where_charaktere_id($id)->where_anwesenheit(1)->count();
		$mcount[2] = Missionseintrag::where_charaktere_id($id)->where_anwesenheit(2)->count();
		$mcount[3] = Missionseintrag::where_charaktere_id($id)->where('leiterpins', '>', 0)->count();
		$mcount[4] = Missionseintrag::where_charaktere_id($id)->where('gastpins', '>', 0)->count();


		return View::make('charakter.profil')
			->with('charakter', $char)
			->with('notizen', $notizen)
			->with('ncount', $ncount)
			->with('admin', false)
			->with('missionen', $missionen)
			->with('mcount', $mcount)
			->with('title', 'Charakter - ' . $char->name);
	}

		public function action_liste() {
		$chars = Charakter::paginate();
		$no = Charakter::count();
		return View::make('charakter.liste')
			->with('charaktere', $chars)
			->with('no', $no)
			->with('title', 'Charakterliste');
	}
}