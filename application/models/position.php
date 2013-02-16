<?php
/**
 * @author Daniel
 *
 * application/models/position.php
 */

class Position extends Eloquent {
	public static $table = "positionen";

	public function komponente() {
		retun $this->belongs_to('Komponente', 'komponenten_id');
	}

	public function charakter() {
		return $this->has_many('Charakter', 'positionen_id');
	}
}