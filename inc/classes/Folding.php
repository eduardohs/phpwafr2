<?php
class Folding {

	public static function link($id, $title, $url) {
		$out = "";
		$out .= "<div class='folding' id='fld_" . $id . "'>\n";
		$out .= "<div onclick='foldingShowHide(\"" . $id . "\",\"" . $url . "\")' class='title' id='" . $id . "_title'>\n";
		$out .= "<span><img id='" . $id . "_imgfld' src='../img/icons/bullet_mais.gif' /></span> <span>" . $title . "</span>\n";
		$out .= "</div>\n";
		$out .= "<div class='content' id='" . $id . "_content' style='display: none'>\n";
		$out .= "carregando...";
		$out .= "</div>\n";
		$out .= "</div>\n";
		return $out;
	}

}
