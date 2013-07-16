<?php
class Messages {

	public static function handleMessages() {
		if (strlen(Session::get("message-stack")) + strlen(Session::get("message-error")) > 0) {
			$out = "<div id='block-appmsg'><div id='appmsg-container'>";
			if (strlen(Session::get("message-stack")) > 0) {
				$out .= "<div id='appmsg' class='ui-state-highlight ui-corner-all'>" . Session::get("message-stack") . "</div>";
				Session::set("message-stack", "");
			}
			if (strlen(Session::get("message-error")) > 0) {
				$out .= "<div id='appmsgerror' class='ui-state-error ui-corner-all'>" . Session::get("message-error") . "</div>";
				Session::set("message-error", "");
			}
			$out .= "</div></div>";
			echo $out;
		}
	}

	public static function sendSuccess($msg="") {
		Session::set("message-stack", $msg);
	}

	public static function sendError($msg="") {
		Session::set("message-error", $msg);
	}

}
