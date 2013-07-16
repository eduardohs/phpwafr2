<?php
class Form {

	private $id;
	private $action;
	private $method;
	private $blockFields;
	private $blockHidden;
	private $upload;
	private $comment;
	private $lineFields = array();
	private $listaColspan = array();
	private $maxCols = 0;
	private $countCol = 0;
	private $autoNewLine = true;
	private $preventSubmit;
	private $target;

	public function setUpload($doUpload = false) {
		$this->upload = $doUpload;
	}

	public function setComment($comment) {
		$this->comment = $comment;
	}
	
	public function setTarget($target) {
		$this->target = $target!=""?" target='".$target."' ":"";
	}

	public function setAction($theAction) {
		$this->action = $theAction;
	}

	public function setMethod($theMethod) {
		$this->method = $theMethod;
	}

	public function Form($id = "frm", $action = "", $method = "POST", $preventSubmit=true) {
		$this->id = $id;
		$this->action = $action;
		$this->method = $method;
		$this->blockFields = "";
		$this->blockHidden = "";
		$this->addHidden("executed", "s");
		$this->preventSubmit = $preventSubmit;
	}

	public function setAutoNewLine($newLine) {
		$this->autoNewLine = $newLine;
	}

	public function addHidden($varName, $varValue) {
		$this->blockHidden .= "<input type='hidden' id='" . $varName . "' name='" . $varName . "' value='" . $varValue . "' />\n";
	}

	public function addField($label = "&nbsp;", $field = "", $hint = "") {
		$h = "";
		if ($hint != "") {
			$h = Element::hint($hint);
		}
		$this->blockFields .= "<th>" . $label . "</th>";
		$this->blockFields .= "<td>" . $field . $h . "</td>";
		$this->countCol += 2;
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

	public function addBreak($text = "&nbsp;", $ident=false) {
		if ($ident) {
			$this->lineFields[] = "<tr><td></td><td class='ui-state-default separator' >" . $text . "</td></tr>\n";
			$this->listaColspan[] = 2;
		} else {
			$this->lineFields[] = "<tr><td class='ui-state-default separator' colspan='{%}'>" . $text . "</td></tr>\n";
			$this->listaColspan[] = 1;
		}
		
	}

	public function getHTML() {
		$out = "<div class='div-form'>\n";
		$enctype = "";
		if ($this->upload)
			$enctype = "enctype='multipart/form-data'";
		
		$prSubmit = "";
		if ($this->preventSubmit) $prSubmit = "onsubmit='return false;'";

		$out .= "<form ".$this->target." name='" . $this->id . "' id='" . $this->id . "' " . $enctype . " action='" . $this->action . "' method='" . $this->method . "' ".$prSubmit." >\n";
		$out .= $this->blockHidden;
		$out .= "<table cellspacing='0' cellpadding='0'>\n";
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
		$out .= "</form>\n";
		if ($this->comment != "") {
			$out .= "<div class='comment'>" . $this->comment . "</div>";
		}
		$out .= "</div>\n";
		return str_replace("{%}", "" . $this->maxCols, $out);
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
