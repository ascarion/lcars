<?php
/**
 * @author Daniel
 *
 * application/models/notiz.php
 */

class Notiz extends Eloquent {
	public static $table = "notizen";

	public function charakter() {
		return $this->belongs_to('Charakter', 'charaktere_id');
	}

	public function autor() {
		return $this->belongs_to('Spieler', 'eintragende_id');
	}

	public function editierer() {
		return $this->belongs_to('Spieler', 'aendernde_id');
	}
}