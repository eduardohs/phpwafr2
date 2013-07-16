<?php
class Box {

	private $title;
	private $width;
	private $content;
	private $buttons;

	public function Box($title = "", $width = "") {
		$this->title = $title;
		$this->width = $width;
	}

	public function setButtons(&$deck) {
		$this->buttons = $deck->getHTML();
	}

	public function add($text = "") {
		$this->content .= $text;
	}
	
	public function getHTML() {
		$out = "<div class='ui-widget-content div-box' style='width: " . $this->width . "'>";
		$out .= "<table>";
		if ($this->title != "") {
			$out .= "<tr><th class='ui-widget-header'>" . $this->title . "</th></tr>";
		}
		if (strlen($this->buttons) > 0) {
			$out .= "<tr><td class='btn'>" . $this->buttons . "</td></tr>";
		}
		$out .= "<tr><td>" . $this->content . "</td></tr>";
		$out .= "</table>";
		$out .= "</div>";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
