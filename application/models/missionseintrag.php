<?php
/**
 * @author Daniel
 *
 * application/models/missionseintraege.php
 */

class Missionseintrag extends Eloquent {
	public static $table = "missionseintraege";

	public function mission() {
		return $this->belongs_to('Mission', 'missionen_id');
	}

	public function charakter() {
		return $this->belongs_to('Charakter', 'charaktere_id');
	}
}