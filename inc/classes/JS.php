<?php
class JS {

	public static function alert($msg) {
		echo "<script type='text/javascript'>";
		echo "Dialog.alert('$msg');";
		echo "</script>";
	}

	public static function reloadOpener() {
		echo "<script type='text/javascript'>\n";
		echo "opener.location.reload();\n";
		echo "</script>\n";
	}

	public static function reload() {
		echo "<script type='text/javascript'>\n";
		echo "location.href = location.pathname + '?clear=1';\n";
		echo "</script>\n";
	}

	public static function load($url) {
		echo "<script type='text/javascript'>\n";
		echo "top.location.href = '" . $url . "';\n";
		echo "</script>\n";
	}

	public static function loadiFrame($url) {
		echo "<script type='text/javascript'>\n";
		echo "location.href = '" . $url . "';\n";
		echo "</script>\n";
	}

}
