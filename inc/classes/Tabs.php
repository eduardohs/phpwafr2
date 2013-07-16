<?php
class Tabs {

	private $item;
	private $status;
	private $url;
	private $level;
	private $onclickFunction;

	public function add($name = ABA_GERAL, $status = false, $url = "", $level = "") {
		$this->item[] = $name;
		$this->status[] = $status;
		$this->url[] = $url;
		$this->level[] = $level;
	}

	public function setOnclickFunction($function) {
		$this->onclickFunction = $function;
	}

	public function getHTML() {
		$out = "<div id='header_tab' class='ui-tabs ui-widget ui-corner-all' style='border: 0;'><ul class='ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all'>";
		for ($x = 0; $x < sizeof($this->item); $x++) {
			if (Security::isValidUser($this->level[$x])) {
				if ($this->status[$x]) {
					$out .= "<li id='xcurrent' class='ui-state-default ui-corner-top ui-tabs-selected ui-state-active'>";
					$out .= "<a id='tab_" . ($x + 1) . "' href='#'>" . $this->item[$x] . "</a>";
					$out .= "</li>";
				} else {
					$out .= "<li class='ui-state-default ui-corner-top' onmouseover='$(this).addClass(\"ui-state-hover\")' onmouseout='$(this).removeClass(\"ui-state-hover\")'>";
					$out .= "<a id='tab_" . ($x + 1) . "' href='";
					$out .= $this->url[$x];
					if (strlen($this->onclickFunction) > 0) {
						$out .= "' onclick='" . $this->onclickFunction . "'>";
					} else {
						$out .= "' >";
					}
					$out .= $this->item[$x];
					$out .= "</a>";
					$out .= "</li>";
				}
			}
		}
		$out .= "</ul></div>";
		$out .= "<div style=\"clear:both\"></div><div style=\"clear:both\"></div>\n";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}

