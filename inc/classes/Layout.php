<?php
class Layout {

	private $out = "";
	
	const LEFT = "left";
	const BOTTOM = "bottom";

	public function __construct() {
		$this->out = "<div id='layout'>\n";
	}

	public function add($id, $conteudo, $posicao=Layout::LEFT, $width="", $height="") {
		$alinhamento = "";
		if (strtolower($posicao) == Layout::LEFT) {
			$alinhamento = "float: left;";
		}

		$strWidth = $width != "" ? "width: " . $width . ";" : "";
		$strHeight = $height != "" ? "height: " . $height . ";" : "";

		$this->out .= "<div id='" . $id . "' style='" . $alinhamento . $strWidth . $strHeight . "'>" . $conteudo . "</div>\n";
	}

	public function writeHTML() {
		$this->out .= "</div>\n";
		echo $this->out;
	}

}
