<?php
class Dates {

	public static function format($data) {
		return implode(preg_match("~\/~", $data) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data) == 0 ? "-" : "/", $data)));
	}
	
	public static function addDays($date, $nDays) {
		if (!isset($nDays)) {
			$nDays = 1;
		}
		$aVet = Explode("/", $date);
		return date("d/m/Y", mktime(0, 0, 0, $aVet[1], $aVet[0] + $nDays, $aVet[2]));
	}

}
