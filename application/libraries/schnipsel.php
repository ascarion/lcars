<?php

class Schnipsel {

	public static function pinicon ($typ, $anzahl, $invertiert = false) {
		if($typ == "missionspins") {
			$tstring = "icon-check";
			$name = "Missionspins";
		} elseif ($typ == "leiterpins") {
			$tstring = "icon-edit";
			$name = "Leiterpins";
		} elseif ($typ == "gastpins") {
			$tstring = "icon-share";
			$name ="Gastpins";
		} else {
			return false;
		}

		if($invertiert) {
			$istring = "";
		} else {
			$istring = " icon-white";
		}

		return "<i class='$tstring$istring' title='$name'></i>&nbsp;" . $anzahl;
	}

	public static function pinlabel ($typ, $anzahl) {
		if($anzahl > 0) {
			$fstr = "success";
		} else {
			$fstr = "important";
		}

		if ($anzahl != 0)
			return '<div class="pull-right"><span class="label pinlabel label-' . $fstr .'">' . 
				Schnipsel::pinicon($typ, $anzahl) . '</span></div>';
		else
			return "";
	}

	public static function editbtn ($id) {
		return '<div class="pull-right">' .
			'<button class="btn btn-mini" id="'. $id . 
			'"><i class="icon-pencil icon-white"></i></button>'.
			'</div>';
	}

	public static function datumsformat($datum) {
		return Datum::createFromTimestamp(strtotime($datum));
	}

}