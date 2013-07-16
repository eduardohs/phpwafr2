<?php
class Accordion {

	private $id;
	private $normal;
	private $title;
	private $content;
	private $level;

	public function add($title, $content = "", $level = "") {
		$this->title[] = $title;
		$this->content[] = $content;
		$this->level[] = $level;
	}
	
	public function Accordion($id="accordion", $normal=true) {
		$this->id = $id;
		$this->normal = $normal;
	}

	public function getHTML() {
		$t = $this->normal?"accordion":"multiaccordion";
		$out = "<div class='$t' id='".$this->id."'>\n";
		for ($x = 0; $x < sizeof($this->title); $x++) {
			if (Security::isValidUser($this->level[$x])) {
				$out .= "<h3><a href='#".$this->id.$x."'>".$this->title[$x]."</a></h3><div>".$this->content[$x]."</div>\n";
			}
		}
		$out .= "</div>\n";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
