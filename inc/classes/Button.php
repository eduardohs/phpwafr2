<?php
class Button {

	private $id;
	private $level;

	public function add($id, $title, $level = "") {
		$this->id[] = $id;
		$this->title[] = $title;
		$this->level[] = $level;
	}

	public function getHTML() {
		$out = "";
		for ($x = 0; $x < sizeof($this->id); $x++) {
			if (Security::isValidUser($this->level[$x])) {
				$out .= "<input class='ui-button' type='button' id='" . $this->id[$x] . "' " . "name='" . $this->id[$x] . "' " . "value='" . $this->title[$x] . "' /> ";
			}
		}
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

	public static function quickButton($name, $title, $level = "") {
		$out = "";
		if (Security::isValidUser($level)) {
			$out = "<input role='button' class='ui-button ui-widget ui-state-default ui-corner-all' style='font-size: small; margin: 0px 0 0px 4px; ' type='button' id='" . $name . "' " . "name='" . $name . "' " . "value='" . $title . "' />";
		}
		return $out;
	}

	public static function icon($id, $icon, $title="", $onclick="", $onmouseover="") {
		return "<div id='".$id."' title='".$title."' class='button-icon' onclick='".$onclick."' onmouseover='".$onmouseover."' />".$icon."</div>";
	}

	public static function iconButton($title, $icon, $onclick="", $onmouseover="") {
		return "<div onclick='".$onclick."' onmouseover='$(this).addClass(\"ui-state-hover\");".$onmouseover."' onmouseout='$(this).removeClass(\"ui-state-hover\")' style='vertical-align: top; height: 21px; width: 23px; cursor: pointer;' class='ui-button ui-state-default ui-corner-all' title='".$title."'><span style='margin: 3px;' class='ui-icon ".$icon."'></span></div>";
	}
}
