<?php
class Param {

	public static function get($param_name, $escape = true) {
		$valor = $_REQUEST[$param_name];
		if (is_array($valor))
			return $valor;
		if (!is_numeric($valor)) {
			if ($escape) {
				$valor = strip_tags($valor);
				//$valor = preg_replace(sql_regcase("/(from|select|insert|delete|where|drop table|show tables|#|\*|--|\\\\)/"), "", $valor);
				$valor = trim($valor);
				if (!get_magic_quotes_gpc()) {
					$valor = str_replace("'", "\'", $valor);
				}
			}
		}
		return $valor;
	}

	public static function getArray($param_name) {
		$valor = $_REQUEST[$param_name];
		if (is_array($valor)) {
			return $valor;
		} else {
			return array();
		}
	}
	
	public static function getStringFromArray($param_name) {
		return implode(",", Param::getArray($param_name));
	}

	public static function getString($param_name, $default = null) {
		$valor = $_REQUEST[$param_name];
		if (is_array($valor))
			return $valor;
		if (strlen($valor) == 0)
			return $default;
		return $valor;
	}

	public static function getInt($param_name, $default = 0) {
		$valor = intval($_REQUEST[$param_name]);
		if ($valor == 0)
			return $default;
		return $valor;
	}

}
