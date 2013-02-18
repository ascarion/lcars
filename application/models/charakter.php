<?php
/**
 * @author Daniel
 *
 * application/models/charakter.php
 */

class Charakter extends Eloquent {
	public static $table = "charaktere";

	public function rang() {
		return $this->belongs_to('Rang', 'raenge_id');
	}

	public function spieler() {
		return $this->belongs_to('Spieler');
	}

	public function position() {
		return $this->belongs_to('Position', 'positionen_id');
	}

	public function notizen() {
		return $this->has_many('Notiz', 'charaktere_id');
	}
}