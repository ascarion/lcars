<?php
/**
 * @author Daniel
 *
 * application/models/spieler.php
 */


class Spieler extends Eloquent {
	public static $table = "spieler";

	public function charaktere() {
		return $this->has_many('Charakter');
	}

	public function rolle() {
		return $this->belongs_to('Rolle', 'rollen_id');
	}

}

// EOF