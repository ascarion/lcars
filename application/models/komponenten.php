<?php
/**
 * @author Daniel
 *
 * application/models/charakter.php
 */

class Komponente extends Eloquent {
	public static $table = "komponenten";

	public function position() {
		return $this->has_many('Position', 'komponenten_id');
	}

	public function mission() {
		return $this->has_many('Mission', 'komponenten_id');
	}
}