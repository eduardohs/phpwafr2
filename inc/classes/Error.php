<?php
class Error { 

	private $strError;
	private $count;

	public function add($error = '') {
		$this->strError .= "<li>" . $error . "</li>";
		$this->count++;
	}

	public function hasError() {
		return $this->count > 0;
	}

	public function toString() {
		if ($this->count > 0) {
			return "<ul>" . $this->strError . "</ul>";
		} else {
			return "";
		}
	}

}
