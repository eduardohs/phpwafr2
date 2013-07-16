<?php
class Link {

	private $title;
	private $url;
	private $alt;
	private $param;
	private $value;

	public function Link($title, $url, $alt = "Clique aqui") {
		$this->title = $title;
		$this->url = $url;
		$this->alt = $alt;
	}

	public function addParameter($param, $value) {
		$this->param[] = $param;
		$this->value[] = $value;
	}

	public function getLink() {
		$querystring = "";
		for ($x = 0; $x < sizeof($this->param); $x++) {
			$querystring .= "&" . $this->param[$x] . "=" . $this->value[$x];
		}
		$querystring = substr_replace($querystring, "?", 0, 1);
		if (sizeof($this->param) == 0)
			$querystring = "";
		$querystring = $this->url . $querystring;
		return "<a href='$querystring' title='" . $this->alt . "' >" . $this->title . "</a>";
	}

}
