<?php
class DBVal {

	public static function checkFK($table, $key, $val) {
		if (strlen($val)==0) return false;
		$sql = "SELECT count($key) FROM $table WHERE $key IN ($val)";
		$qt = DBH::getColumn($sql);
		return ($qt > 0);
	}

	public static function isDuplicated($tabela, $campo_valor, $key_field, $value, $chave = "") {
		$return = false;
		if (strlen($value)) {
			$iCount = 0;
			if ($chave == "") {
				$iCount = DBH::getColumn("SELECT count(*) AS qtde FROM $tabela WHERE $campo_valor='$value'");
			} else {
				$iCount = DBH::getColumn("SELECT count(*) AS qtde FROM $tabela WHERE $campo_valor='$value' AND NOT ($key_field=$chave)");
			}
			if ($iCount > 0)
				$return = true;
		}
		return $return;
	}

}
