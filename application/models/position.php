<?php
/**
 * @author Daniel
 *
 * application/models/position.php
 */

class Position extends Eloquent {
	public static $table = "positionen";
	public $includes = array('komponente');

	public function komponente() {
		return $this->belongs_to('Komponente', 'komponenten_id');
	}

	public function charaktere() {
		return $this->has_many('Charakter', 'positionen_id');
	}
}