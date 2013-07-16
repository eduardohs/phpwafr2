<?php
class Grid {

	private $block;
	private $row;
	private $columns;
	private $currcol;
	private $id;
	private $width;
	private $height;

	public function Grid($id, $columns, $width="200px", $height="200px") {
		$this->columns = $columns;
		$this->currcol = 0;
		$this->id = $id;
		$this->width = $width;
		$this->height = $height;
	}

	private function addRow() {
		$this->block .= "<div class='ui-widget-content ui-corner-all grid-row' style='width: " . $this->width . "; height: " . $this->height . "'>" . $this->row . "</div>\n";
		$this->row = "";
		$this->currcol = 0;
	}

	public function addItem($item = "&nbsp;") {
		$this->row .= "<div class='grid-item'>" . $item . "</div>";
		$this->currcol++;
		if ($this->columns == $this->currcol)
			$this->addRow();
	}

	public function getHTML() {
		$out = "<div id='" . $this->id . "' class='grid-container'>\n";
		$out .= $this->block;
		$out .= "</div>\n";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
