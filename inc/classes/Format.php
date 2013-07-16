<?php
class Format {

	public static function simNao($str) {
		$result = "Não";
		if (($str == "1") || (strtoupper($str) == "S"))
			$result = "Sim";
		return $result;
	}

	public static function date($date, $format = "d/m/Y") {
		$months = array("january" => "Janeiro", "february" => "Fevereiro", "march" => "Março", "april" => "Abril", "may" => "Maio", "june" => "Junho", "july" => "Julho", "august" => "Agosto", "september" => "Setembro", "october" => "Outubro", "november" => "Novembro",
			"december" => "Dezembro");
		$weeks = array("sunday" => "Domingo", "monday" => "Segunda", "tuesday" => "Terça", "wednesday" => "Quarta", "thursday" => "Quinta", "friday" => "Sexta", "saturday" => "Sábado");
		$months3 = array("jan" => "jan", "feb" => "fev", "mar" => "mar", "apr" => "abr", "may" => "mai", "jun" => "jun", "jul" => "jul", "aug" => "ago", "sep" => "set", "oct" => "out", "nov" => "nov", "dec" => "dez");
		$weeks3 = array("sun" => "dom", "mon" => "seg", "tue" => "ter", "wed" => "qua", "thu" => "qui", "fri" => "sex", "sat" => "sab");

		$date = strtolower(date($format, strtotime($date)));
		$date = strtr($date, $months);
		$date = strtr($date, $weeks);
		$date = strtr($date, $months3);
		$date = strtr($date, $weeks3);
		return $date;
	}

	public static function toHtml($text) {
		$text = str_replace(chr(13), "<br/>", $text);
		return $text;
	}

}
