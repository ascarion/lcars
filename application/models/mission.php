<?php
/**
 * @author Daniel
 *
 * application/models/mission.php
 */

class Mission extends Eloquent {
	public static $table = "missionen";

	public function komponente() {
		return $this->belongs_to('Komponente', 'komponente_id');
	}

	public function eintrag() {
		return $this->has_many('Missionseintrag', 'missionen_id');
	}

	public function autor() {
		return $this->belongs_to('Spieler', 'eintragende_id');
	}

	public function editierer() {
		return $this->belongs_to('Spieler', 'aendernde_id');
	}
}