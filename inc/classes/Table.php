<?php
class Table {

	private $block;
	private $row;
	private $columns;
	private $currcol;
	private $alternate = false;
	private $id;
	private $idHidden;
	private $valueHidden;
	private $method;
	private $rs = NULL;
	private $footer = false;

	public function Table($id, $columns, $method="post") {
		$this->columns = $columns;
		$this->currcol = 0;
		$this->id = $id;
		$this->method = $method;
	}

	public function addHidden($id, $value) {
		$this->idHidden[] = $id;
		$this->valueHidden[] = $value;
	}

	public function setResultSet(&$resultset) {
		$this->rs = $resultset;
	}
	
	public function setFooter($footer) {
		$this->footer = $footer;
	}

	private function addRow($head=false) {
		$st = $this->alternate ? "odd" : "even";
		if ($head) {
			if ($this->footer) {
				$this->block .= "<thead><tr class='ui-widget-header'>" . $this->row . "</tr></thead><tfoot><tr class='ui-widget-header'>".$this->row."</tr></tfoot><tbody>\n";
			} else {
				$this->block .= "<thead><tr class='ui-widget-header'>" . $this->row . "</tr></thead><tfoot></tfoot><tbody>\n";
			}
		} else {
			$this->block .= "<tr class='$st'>" . $this->row . "</tr>\n";
		}
		$this->row = "";
		$this->currcol = 0;
		$this->alternate = !$this->alternate;
	}

	public function addData($data = "&nbsp", $align = "L", $bold = false, $cor = "") {
		$al = $this->getAlignString($align);
		if ($bold)
			$al .= "font-weight: bold;";
		if ($cor != "")
			$al .= "color: $cor;";

		$this->row .= "<td style='$al'>" . $data . "</td>";
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function addDataID($id, $data = "&nbsp", $align = "L", $bold = false, $cor = "") {
		$al = $this->getAlignString($align);
		if ($bold)
			$al .= "font-weight: bold;";
		if ($cor != "")
			$al .= "color: $cor;";

		$this->row .= "<td id='".$id."' style='$al'>" . $data . "</td>";
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}
	
	public function addDataLabel($id, $data = "&nbsp", $transport=false, $align = "L", $bold = false, $cor = "") {
		$al = $this->getAlignString($align);
		if ($bold)
			$al .= "font-weight: bold;";
		if ($cor != "")
			$al .= "color: $cor;";

		if ($transport) {
			$this->row .= "<td style='$al'>" . Element::label("sel_".$id,Element::placeHolder("dummy_".$id,$data)) . "</td>";
		} else {
			$this->row .= "<td style='$al'>" . Element::label("sel_".$id,$data) . "</td>";
		}
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function addCheckboxData($data) {
		$al = $this->getAlignString("C");
		$this->row .= "<td class='checkbox' $al><input type=\"checkbox\" id=\"sel_" . $data . "\" name=\"sel[]\" value=\"$data\"></td>";
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function addRadioData($data) {
		$al = $this->getAlignString("C");
		$st = $this->alternate ? "odd" : "even";
		$this->row .= "<td class='radio " . $st . "' $al><input type=\"radio\" id=\"sel_" . $data . "\" name=\"sel\" value=\"$data\" /></td>";
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function addColumnHeader($title = "&nbsp;", $ord = false, $width = "1", $align = "L") {
		global $form_sorting;
		$this->currcol++;
		$cs = $this->currcol;
		$al = $this->getAlignString($align);

		$this->row .= "<th width='$width' style='$al'>";
		if ($ord) {
			$this->row .= "<a title='" . "Ordenar por" . " $title' href='" . $_SERVER['PHP_SELF'] . "?Sorting=$cs&Sorted=$form_sorting'>" . $title . "</a>";
		} else {
			$this->row .= $title;
		}
		$this->row .= "</th>";
		$this->alternate = true;
		if ($this->columns == $this->currcol)
			$this->addRow(true);
	}

	public function addCheckboxColumnHeader() {
		$this->row .= "<th width='1'><input type='checkbox' name='checkall' class='checkall' onclick=\"FormUtil.checkAll('" . $this->id . "')\" /></th>";
		$this->alternate = true;
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function addBreak($title = "&nbsp") {
		$this->row .= "<td class='ui-state-default separator' colspan='" . $this->columns . "'>" . $title . "</td>";
		$this->addRow();
		$this->alternate = false;
	}

	private function getAlignString($align) {
		$align = strtoupper($align);
		if ($align == "L")
			$al = "text-align: left; ";
		if ($align == "C")
			$al = "text-align: center; ";
		if ($align == "R")
			$al = "text-align: right; ";
		return $al;
	}

	public function getHTML() {
		$out = "<div class='div-table'>\n";
		$out .= "<form id='" . $this->id . "' name='" . $this->id . "' method='" . $this->method . "'>\n";
		for ($i = 0; $i < sizeof($this->idHidden); $i++) {
			$out .= "<input type='hidden' name='" . $this->idHidden[$i] . "' id='" . $this->idHidden[$i] . "' value='" . $this->valueHidden[$i] . "' />\n";
		}
		$out .= "<table cellpadding='0' cellspacing='0'>\n";
		$out .= $this->block;
		$out .= "</tbody></table>\n";
		$out .= "</form>\n";
		$out .= "</div>\n";
		return $out;
	}

	public function writeHTML() {
		if ($this->rs != NULL) {
			if ($this->rs->numrows() > 0) {
				echo $this->getHTML();
				Paging::writeLinks($this->rs->totalpages());
				Paging::writeStatus($this->rs->totalpages(), $this->rs->numrows());
			} else {
				Paging::writeStatusIfEmpty();
			}
		} else {
			echo $this->getHTML();
		}
	}
}

