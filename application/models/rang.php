<?php
/**
 * @author Daniel
 *
 * application/models/rang.php
 */

class Rang extends Eloquent {
	public static $table = "raenge";

	public function charakter() {
		return $this->has_many('Charakter', 'raenge_id');
	}

	public function nachfolger() {
		return $this->belongs_to('Rang', 'nachfolger');
	}

	public function vorgaenger() {
		return $this->has_one('Rang', 'nachfolger');
	}
}