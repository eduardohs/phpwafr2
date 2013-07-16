<?php
class View {

	private $id;
	private $blockFields;
	private $lineFields = array();
	private $listaColspan = array();
	private $maxCols = 0;
	private $countCol = 0;
	private $autoNewLine = true;

	public function View($id = "view") {
		$this->id = $id;
		$this->blockFields = "";
	}

	public function setAutoNewLine($newLine) {
		$this->autoNewLine = $newLine;
	}

	public function addData($label = "&nbsp;", $value = "") {
		$this->blockFields .= "<td><div class='label'>" . $label . "</div><div class='ui-widget-content ui-corner-all value'>" . $value . "</div></td>";
		$this->countCol += 1;
		if ($this->autoNewLine)
			$this->newLine();
	}

	public function newLine() {
		if ($this->countCol > 0) {
			$this->listaColspan[] = $this->countCol;
			if ($this->countCol > $this->maxCols)
				$this->maxCols = $this->countCol;
			$this->countCol = 0;

			$this->lineFields[] = "<tr>" . $this->blockFields . "</tr>\n";
			$this->blockFields = "";
		}
	}

	public function addBreak($text = "&nbsp;") {
		$this->lineFields[] = "<tr><td class='' colspan='{%}'><div class='ui-state-default ui-corner-all separator'>" . $text . "</div></td></tr>\n";
		$this->listaColspan[] = 1;
	}

	public function getHTML() {
		$out = "<div class='div-view'>\n";
		$out .= "<table cellspacing=0 border=0 >\n";
		for ($x = 0; $x < sizeof($this->lineFields); $x++) {
			$numCols = intval($this->listaColspan[$x]);
			$colspan = $this->maxCols - $numCols + 1;
			if ($colspan > 1) {
				$pos = strpos($this->lineFields[$x], "<td") + 3;
				$str_colspan = " colspan=\"" . $colspan . "\" ";
				$line = substr_replace($this->lineFields[$x], $str_colspan, $pos, 0);
				$out .= $line;
			} else {
				$out .= $this->lineFields[$x];
			}
		}
		$out .= "</table>\n";
		$out .= "</div>\n";
		$out = str_replace("{%}", "" . $this->maxCols, $out);
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
