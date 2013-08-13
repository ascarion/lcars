<?php

class Komponente_Controller extends Base_Controller {
	public function action_index() {
		return Redirect::to_action('komponente@liste');
	}

	public function action_profil($id) {
		$komponente = Komponente::find($id);

		$positionen = $komponente->positionen()->get();
		$charaktere = array();
		foreach($positionen as $p) {
			$charaktere =	array_merge($charaktere, $p->charaktere()->get());
		}

		$missionen = $komponente->missionen()->order_by('created_at', 'desc')->get();

		Return View::make('komponente.profil')
			->with('title', 'Komponente - ' . $komponente->name)
			->with('komponente', $komponente)
			->with('positionen', $positionen)
			->with('missionen', $missionen)
			->with('charaktere', $charaktere);
	}

	public function action_liste() {
		$komponente = Komponente::paginate();
		$no = Komponente::count();
		return View::make('komponente.liste')
			->with('komponenten', $komponente)
			->with('no', $no)
			->with('title', "Komponentenliste");
	}

}