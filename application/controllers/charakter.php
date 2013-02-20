<?php

class Charakter_Controller extends Base_Controller {
	
	public function action_profil($id) {
		$char = Charakter::find($id);

		return View::make('charakter.profil')
			->with('charakter', $char)
			->with('title', 'Charakter - ' . $char->name);
	}
}