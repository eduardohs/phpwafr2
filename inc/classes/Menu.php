<?php
class Menu {

	private $saida;

	public function __construct() {
		$this->saida = "<ul class='sf-menu'>\n";
	}

	public function startMenuBlock($title, $url="#", $level="", $current=false) {
		if (Security::isValidUser($level)) {
			$cl = "";
			if ($current)
				$cl = " class='current' ";
			$this->saida .= "<li $cl>\n<a href='" . $url . "'>" . $title . "</a><ul>\n";
		}
	}

	public function endMenuBlock() {
		$this->saida .= "</ul></li>\n";
	}

	public function item($title, $url, $level="") {
		if (Security::isValidUser($level)) {
			$this->saida .= "<li><a href='" . $url . "'>" . $title . "</a></li>\n";
		}
	}

	public function getHTML() {
		return $this->saida . "</ul>\n";
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
