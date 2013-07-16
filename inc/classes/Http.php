<?php
class Http {

	public static function redirect($page) {
		header("Location: " . $page);
		die();
	}

}
