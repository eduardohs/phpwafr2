<?php

class Validation {

	public static function date($data) {
		$result = false;
		$aData = explode("/", $data);
		$d = $aData[0];
		$m = $aData[1];
		$y = $aData[2];
		$result = checkdate($m, $d, $y);
		return $result;
	}

	public static function regex($str, $tipo, $tam = 0) {
		$padrao = '';
		if ($tam > 0) {
			if (strlen($str) > $tam) {
				return false;
			}
		}
		if ($tipo == 'n1') {
			$padrao = '^[0-9]+$';
		} //numerico
		if ($tipo == 'n2') {
			$padrao = '^[0-9 ]+$';
		} //numerico com espaços
		if ($tipo == 'fl') {
			$padrao = '^[+-]?(([0-9]+|[0-9]{1,3}(\.[0-9]{3})+)(\,[0-9]*)?|\,[0-9]+)$';
		} //float
		if ($tipo == 'a1') {
			$padrao = '^[A-Za-zÀ-ú]*$';
		} // alfa
		if ($tipo == 'a2') {
			$padrao = '^[A-Za-zÀ-ú0-9\&\; ]*$';
		} // string - alfanumerico
		if ($tipo == 'a3') {
			$padrao = '^[A-Za-z0-9]*$';
		} // string - alfanumerico sem acentuação
		if ($tipo == 'a4') {
			$padrao = '^[A-Za-zÀ-ú0-9@#%!&\*\?\)\(\$\}\{\+\.\-\,\;\: ]*$';
		} // string - alfanumerico com caracteres especiais
		if ($tipo == 'a5') {
			$padrao = '^[A-Za-zÀ-ú0-9@#%!&\*\?\)\(\$\}\{\+\.\-\_\,\;\:\n\r ]*$';
		} // string - alfanumerico com caracteres especiais
		if ($tipo == 'ht') {
			$padrao = '^[A-Za-zÀ-ú0-9@#%!&\*\?\)\(\$\}\{\+\.\-\_\,\;\:\n\r\<\>\/ ]*$';
		} // caracteres de um trecho HTML
		if ($tipo == 'em') {
			$padrao = '^[0-9a-zA-Z]+[\_\-\.]?[0-9a-zA-Z]+@(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9]\.)+[A-Za-z]{2,6}|\[[0-9]{1,3}(\.[0-9]{1,3}){3}\])$';
		} //email
		if ($tipo == 'u1') {
			$padrao = '^((ht|f)tp(s?)\:\/\/|~\/|\/){1}([0-9a-zA-Z]+:[0-9a-zA-Z]+@)?([a-zA-Z]{1}([0-9a-zA-Z-]+\.?)*(\.[0-9a-zA-Z]{2,5}){1})$';
		} //url
		if ($tipo == 'u2') {
			$padrao = '^((ht|f)tp(s?)\:\/\/|~\/|\/){1}([0-9a-zA-Z]+:[0-9a-zA-Z]+@)?(([a-zA-Z]{1}([0-9a-zA-Z-]+\.?)*(\.[0-9a-zA-Z]{2,5}){1})(:[0-9]{1,5})?)?((\/?[0-9a-zA-Z_-]+\/)+|\/?)([0-9a-zA-Z]+([0-9a-zA-Z_-]?[0-9a-zA-Z]+)?\.[0-9a-zA-Z]{3,4})?([,][0-9a-zA-Z]+)*((\?[0-9a-zA-Z]+=[0-9a-zA-Z]+)?(&[0-9a-zA-Z]+=[0-9a-zA-Z]+)*([,][0-9a-zA-Z]*)*)?$';
		} //url com subpasta e arquivo
		if ($tipo == 't1') {
			$padrao = '^[0-9]{10}$';
		} //telefone com DDD
		if ($tipo == 't2') {
			$padrao = '^[0-9]{12}$';
		} //telefone com DDD e país
		return ereg($padrao, $str);
	}

	function cpf($cpf) {
		$cpf = str_pad(ereg_replace('[^0-9]', '', $cpf), 11, '0', STR_PAD_LEFT);

		if (strlen($cpf) != 11 || $cpf == '00000000000' || $cpf == '11111111111' || $cpf == '22222222222' || $cpf == '33333333333' || $cpf == '44444444444' || $cpf == '55555555555' || $cpf == '66666666666' || $cpf == '77777777777' || $cpf == '88888888888' || $cpf == '99999999999') {
			return false;
		} else {
			for ($t = 9; $t < 11; $t++) {
				for ($d = 0, $c = 0; $c < $t; $c++) {
					$d += $cpf{$c} * (($t + 1) - $c);
				}
				$d = ((10 * $d) % 11) % 10;
				if ($cpf{$c} != $d) {
					return false;
				}
			}
			return true;
		}
	}

	function cnpj($str) {
		if (!preg_match('|^(\d{2,3})\.?(\d{3})\.?(\d{3})\/?(\d{4})\-?(\d{2})$|', $str, $matches))
			return false;

		array_shift($matches);

		$str = implode('', $matches);
		if (strlen($str) > 14)
			$str = substr($str, 1);

		$sum1 = 0;
		$sum2 = 0;
		$sum3 = 0;
		$calc1 = 5;
		$calc2 = 6;

		for ($i = 0; $i <= 12; $i++) {
			$calc1 = $calc1 < 2 ? 9 : $calc1;
			$calc2 = $calc2 < 2 ? 9 : $calc2;

			if ($i <= 11)
				$sum1 += $str[$i] * $calc1;

			$sum2 += $str[$i] * $calc2;
			$sum3 += $str[$i];
			$calc1--;
			$calc2--;
		}

		$sum1 %= 11;
		$sum2 %= 11;

		return ($sum3 && $str[12] == ($sum1 < 2 ? 0 : 11 - $sum1) && $str[13] == ($sum2 < 2 ? 0 : 11 - $sum2));
	}

}
