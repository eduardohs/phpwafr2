<?php
class Calendar {
	private $mes;
	private $ano;
	private $eventos;

	public function Calendar($mes, $ano) {
		$this->mes = $mes;
		$this->ano = $ano;
		settype($eventos, "array");
	}

	public function addEvento($dia, $hora, $conteudo, $url = "") {
		$p["dia"] = $dia;
		$p["hora"] = $hora;
		$p["conteudo"] = $conteudo;
		$p["url"] = $url;
		$this->eventos[] = $p;
	}

	public function getHTML() {
		$d = mktime(0, 0, 0, $this->mes, 1, $this->ano);
		$u = date('t', $d);
		$weekDay = date('w', $d);

		$cal = new Table("frmCal", 7);
		$cal->addColumnHeader("Domingo", false, "12%", "C");
		$cal->addColumnHeader("Segunda", false, "15%", "C");
		$cal->addColumnHeader("Terça", false, "15%", "C");
		$cal->addColumnHeader("Quarta", false, "15%", "C");
		$cal->addColumnHeader("Quinta", false, "15%", "C");
		$cal->addColumnHeader("Sexta", false, "15%", "C");
		$cal->addColumnHeader("Sábado", false, "13%", "C");

		for ($i = 0; $i < $weekDay; $i++) $cal->addData("&nbsp;");
		for ($i = 0; $i < $u; $i++) {
			$dia = $i + 1;

			$hl = "";
			if (($dia == date("j")) && (intval($this->mes)) == date("n") && (intval($this->ano) == date("Y"))) $hl = "hoje";
			$cal->addData("<span class='calendario-dia ".$hl."'>" . $dia . "</span>" . $this->getEventos($dia));
		}
		for ($k = $weekday; $k < 6; $k++) $cal->addData("&nbsp");
		return $cal->getHTML();
	}

	public function getEventos($dia) {
		$out = "<ul>";
		for ($i = 0; $i < sizeof($this->eventos); $i++) {
			$p = $this->eventos[$i];
			if ($p["dia"] == $dia) {
				$hifem = " - ";
				if ($p["hora"]=="") $hifem = "";
				if ($p["url"] != "") {
					$link = new Link(trim($p["hora"] . $hifem . $p["conteudo"]), $p["url"]);
					$out .= "<li>" . $link->getLink() . "</li>";
				} else {
					$out .= "<li>" . trim($p["hora"] . $hifem . $p["conteudo"] . "</li>");
				}
			}
		}
		$out .= "</ul>";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}
}