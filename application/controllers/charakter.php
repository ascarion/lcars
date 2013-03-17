<?php

class Charakter_Controller extends Base_Controller {
	
	public function action_profil($id) {
		$char = Charakter::find($id);
		$notizen = $char->notizen()->order_by('updated_at', 'desc')->get();
		$ncount = $char->notizen()->count();

		return View::make('charakter.profil')
			->with('charakter', $char)
			->with('notizen', $notizen)
			->with('ncount', $ncount)
			->with('admin', false)
			->with('title', 'Charakter - ' . $char->name);
	}
}