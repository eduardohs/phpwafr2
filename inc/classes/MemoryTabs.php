<?php
class MemoryTabs {

	private $id;
	private $title;
	private $content;
	private $status;
	private $level;

	public function add($title="Geral", $content="", $status = false, $level = "") {
		$this->title[] = $title;
		$this->content[] = $content;
		$this->status[] = $status;
		$this->level[] = $level;
	}

	public function getHTML() {
		$out = "<div class='memory-tabs'><ul>";
		for ($x = 0; $x < sizeof($this->title); $x++) {
			if (Security::isValidUser($this->level[$x])) {
				$out .= "<li>";
				$out .= "<a href='#tab_" . ($x + 1) . "' >";
				$out .= $this->title[$x];
				$out .= "</a>";
				$out .= "</li>";
			}
		}
		$out .= "</ul>";
		
		for ($x = 0; $x < sizeof($this->title); $x++) {
			if (Security::isValidUser($this->level[$x])) {
				$out .= "<div id='tab_".($x + 1)."'>";
				$out .= $this->content[$x];
				$out .= "</div>";
			}
		}		
		
		$out .= "</div>";
		return $out;
	}

	public function writeHTML() {
		echo $this->getHTML();
	}

}
