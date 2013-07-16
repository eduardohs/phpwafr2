<?php

class Strings {

	public static function generatePassword($size = 6) {
		$senha = "abcdefghjkmnpqrstuvxzwyABCDEFGHIJLKMNPQRSTUVXZYW23456789";
		srand((double) microtime() * 1000000);
		for ($i = 0; $i < $size; $i++) {
			$password .= $senha[rand() % strlen($senha)];
		}
		return $password;
	}

	public static function removeAcentos($string) {
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
		$string = utf8_decode($string);
		$string = strtr($string, utf8_decode($a), $b);
		return utf8_encode($string);
	}

	public static function fullUpper($string) {
		return strtr(strtoupper($string), array(
					"à" => "À",
					"â" => "Â",
					"ã" => "Ã",
					"á" => "Á",
					"è" => "È",
					"é" => "É",
					"ê" => "Ê",
					"ì" => "Ì",
					"î" => "Î",
					"ò" => "Ò",
					"ó" => "Ó",
					"ô" => "Ô",
					"õ" => "Õ",
					"ù" => "Ù",
					"í" => "Í",
					"ú" => "Ú",
					"û" => "Û",
					"ç" => "Ç",
				));
	}

}

