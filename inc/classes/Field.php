<?php

class Field {

	public static function text($id, $value = "", $length = 40, $maxlength = 40, $placeholder = "") {
		$ph = $placeholder==""?"":"placeholder='$placeholder' ";
		$out = "<input type='text' id='$id' name='$id' value='$value' size='$length' maxlength='$maxlength' $ph/>";
		return $out;
	}

	public static function number($id, $value = "", $size = 15, $min = 0, $max = 100, $step = 1) {
		$out = "<input type='number' id='$id' name='$id' class='number' value='$value' size='$size' min='$min' max='$max' step='$step' />";
		return $out;
	}

	public static function select($id, $rows, $default = 0, $all = "") {
		$result = "<select name=\"$id\" id=\"$id\" size=\"1\">\n";
		if ($all != "") {
			$result .= "<option value=\"\">$all</option>\n";
		}
		foreach ($rows as $row) {
			$key = $row["id"];
			$val = $row["label"];
			if ($default == $key) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$result .= "<option value=\"$key\" $selected>$val</option>\n";
		}
		$result .= "</select>\n";
		return $result;
	}

	public static function textInterval($id, $length = 40, $maxlength = 40) {
		$out = Field::text($id . "_1", "", $length, $maxlength);
		$out .= "&nbsp;&nbsp;até&nbsp;&nbsp;";
		$out .= Field::text($id . "_2", "", $length, $maxlength);
		return $out;
	}

	public static function password($id, $value = "", $length = 20, $maxlength = 20, $placeholder = "") {
		$ph = $placeholder==""?"":"placeholder='$placeholder' ";
		$out = "<input class='password' type='password' id='$id' name='$id' value='$value' size='$length' maxlength='$maxlength' $ph/>";
		return $out;
	}

	public static function radio($id, $arr, $sel = "", $dir = "v") {
		$out = "";
		$d = "<br/>";
		$c = "radio-v";
		if ($dir == "h") {
			$d = "";
			$c = SIS_TABLETREADY ? "radio-h" : "radio-h-oldstyle";
		}

		$out .= "<div class='" . $c . "'>";
		if (is_array($arr[0])) { // novo formato
			foreach ($arr as $row) {
				$label = $row["label"];
				$key = $row["id"];
				$select_v = ($sel && $key == $sel) ? " checked" : "";
				$uid = $id . "_" . $key;
				$out .= "<input type=\"radio\" id=\"$uid\" name=\"$id\" value=\"$key\" $select_v><label for=\"" . $uid . "\">$label</label>$d";
			}
		} else { // deprecated
			while (list($key, $val) = each($arr)) {
				$string = explode(",", $val);
				$label = $string[1];
				$value = $string[0];
				$select_v = ($sel && $value == $sel) ? " checked" : "";
				$uid = $id . "_" . $value;
				$out .= "<input type=\"radio\" id=\"$uid\" name=\"$id\" value=\"$value\" $select_v><label for=\"" . $uid . "\">$label</label>$d";
			}
		}
		$out .= "</div>";
		return $out;
	}

	public static function multipleCheckbox($id, $rows, $selectedRows, $direction = "v") {
		$selecionados = array();
		foreach ($selectedRows as $selectedRow) {
			$selecionados[] = $selectedRow["id"];
		}
		if (direction == "v") {
			$out = "";
		} else {
			$out = "<div class='checkbox-group'>";
		}
		foreach ($rows as $row) {
			$checked = "";
			$st = SIS_TABLETREADY ? " class='checkbox-label' " : "";
			if (in_array($row["id"], $selecionados))
				$checked = " checked";
			$uid = $id . "_" . $row["id"];
			if ($direction == "v") {
				$out .= "<input type='checkbox' id='$uid' name='" . $id . "[]' value='" . $row["id"] . "' $checked /> <label for=\"" . $uid . "\">" . $row["label"] . "</label><br/>\n";
			} else {
				$out .= "<div class='multiple-checkbox-h'><input $st type='checkbox' id='$uid' name='" . $id . "[]' value='" . $row["id"] . "' $checked /> <label for=\"" . $uid . "\">" . $row["label"] . "</label></div>";
			}
		}
		if ($direction == "v") {
			$out .= "";
		} else {
			$out .= "</div>";
		}
		return $out;
	}

	public static function textarea($id, $value = "", $rows = 5, $cols = 40, $maximum = 200, $placeholder = "") {
		$ph = $placeholder==""?"":"placeholder='$placeholder' ";
		$str = "<textarea $ph style='vertical-align: middle' " .
				"id='$id' " .
				"name='$id' " .
				"rows='$rows' " .
				"cols='$cols' " .
				"onkeyup=\"textCounter('$id', '$id" . "_counter', $maximum);\" " . ">" . $value .
				"</textarea><span class='text-counter'>" .
				"<span id='" . $id . "_counter'>" . ($maximum - strlen($value)) . "</span></span>";
		return $str;
	}

	public static function richTextEditor($id, $value = "") {
		$str = "<textarea class='richtexteditor' id='$id' name='$id' >$value</textarea>";
		return $str;
	}

	public static function checkbox($id, $value = "", $expr = "", $label = "") {
		$out = "";
		$checked = $expr ? " checked" : "";
		$c = SIS_TABLETREADY ? "checkbox-label" : "";
		if ($label == "")
			$c = SIS_TABLETREADY ? "checkbox" : "";
		$out .= "<input class='$c' type='checkbox' id='$id' name='$id' value='$value' $checked /> <label for='" . $id . "'>" . $label . "</label>";
		return $out;
	}

	public static function file($id, $value = "", $length = 30) {
		$out = "";
		$out .= "<input type='hidden' id='" . $id . "_anterior' name='" . $id . "_anterior' value='$value'>";
		$out .= "<input type='file' id='$id' name='$id' size='$length'>";
		if (strlen(trim($value)) > 0) {
			$out .= "<br>Arquivo atual: <strong>" . $value . "</strong>&nbsp;" . "<input type='checkbox' name='" . $id . "_excluir' value='1'> remover";
		}
		return $out;
	}




	public static function dateSelect($field_name, $date = "") {
		//----- monta select de dia
		if ($date != "") {
			$aDate = explode("-", $date);
			$today_day = $aDate[2];
			$today_month = $aDate[1];
			$today_year = $aDate[0];
		}
		$out = "<select name=\"" . $field_name . "_dia\">\n";
		$out .= "<option value=\"\">--</option>\n";
		for ($i = 1; $i <= 31; $i++) {
			$xday = $i < 10 ? "0" . $i : $i;
			$selected = $today_day == $xday ? " selected" : "";
			$out .= "<option value=\"" . $xday . "\" $selected>" . $xday . "</option>\n";
		}
		$out .= "</select>\n";

		//----- monta select do mes
		$aMonth = array("nulo", "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro");
		$out .= "&nbsp;<select name=\"" . $field_name . "_mes\">\n";
		$out .= "<option value=\"\">--</option>\n";
		for ($i = 1; $i <= 12; $i++) {
			$xmes = $i < 10 ? "0" . $i : $i;
			$selected = $today_month == $xmes ? " selected" : "";
			$out .= "<option value=\"" . $xmes . "\" $selected>" . $aMonth[$i] . "</option>\n";
		}
		$out .= "</select>\n";

		//----- monta select de ano
		$out .= "&nbsp;<select name=\"" . $field_name . "_ano\">\n";
		$out .= "<option value=\"\">--</option>\n";
		for ($i = date("Y"); $i <= date("Y") + 1; $i++) {
			$selected = $today_year == $i ? " selected" : "";
			$out .= "<option value=\"" . $i . "\" $selected>" . $i . "</option>\n";
		}
		$out .= "</select>\n";
		return $out;
	}

	public static function timeSelect($field_name, $time = "") {
		//----- monta select de hora
		if ($time != "") {
			$aTime = explode(":", $time);
			$time_hoje = $aTime[0];
			$today_min = $aTime[1];
		}

		$out = "<select name=\"" . $field_name . "_hora\">\n";
		$out .= "<option value=\"\">--</option>\n";
		for ($i = 0; $i <= 23; $i++) {
			$xtime = $i < 10 ? "0" . $i : $i;
			$selected = $time_hoje == $xtime ? " selected" : "";
			$out .= "<option value=\"" . $xtime . "\" $selected>" . $xtime . "</option>\n";
		}
		$out .= "</select>\n";

		//----- monta select do minuto
		$out .= "&nbsp;<select name=\"" . $field_name . "_minuto\">\n";
		$out .= "<option value=\"\">--</option>\n";
		for ($i = 0; $i <= 55; $i += 5) {
			$xmin = $i < 10 ? "0" . $i : $i;
			$selected = $today_min == $xmin ? " selected" : "";
			$out .= "<option value=\"" . $xmin . "\" $selected>" . $xmin . "</option>\n";
		}
		$out .= "</select>\n";
		return $out;
	}

	public static function lov($id, $value, $label, $paginaLov, $largura) {
		$out = "";
		$out .= "<input type='hidden' id='" . $id . "' name='" . $id . "' value='" . $value . "'/>";
		$out .= "<input type='text' id='" . $id . "Dummy' name='" . $id . "Dummy' value='" . $label . "' size='50' readonly='readonly' /> ";
		$out .= Button::iconButton("Abrir lista de valores", "ui-icon-search", "lov(\"" . $paginaLov . "\",\"" . $id . "\"," . $largura . ")");
		$out .= Button::iconButton("Limpar", "ui-icon-trash", "$(\"#" . $id . "\").val(\"\");$(\"#" . $id . "Dummy\").val(\"\");");
		return $out;
	}

	public static function listboxLov($id, $url, $rows = array(), $altura = 7, $larguraPopup = "400px") {
		$out = "<div class='listbox-lov'>";
		$out .= "<select id='" . $id . "' name='" . $id . "[]' size=" . $altura . " multiple='multiple'>";
		if (sizeof($rows) > 0) {
			foreach ($rows as $row) {
				$out .= "<option value='" . $row["id"] . "'>" . $row["label"] . "</option>";
			}
		}
		$out .= "</select>";
		$out .= "<div class='btn'>";
		$out .= Button::iconButton("Adicionar", "ui-icon-plus", "lovm(\"" . $url . "\",\"" . $larguraPopup . "\")");
		$out .= "<br/>";
		$out .= Button::iconButton("Remover", "ui-icon-minus", "ListboxLov.removeSelected(\"" . $id . "\");");
		$out .= "</div>";
		$out .= "</div>";
		return $out;
	}

	public static function slider($id, $value, $min, $max, $step) {
		$out = "<div style='min-width: 290px;'><input type='text' id='$id' name='$id' value='$value' size='1' readonly='readonly' style='float: left' />";
		$out .= "<div id='" . $id . "_slider' style='width: 80%; float: left; margin-top: 5px; margin-left: 10px;'></div></div>";
		$out .="<script>";
		$out .= "$(function() {";
		$out .= "$( \"#" . $id . "_slider\" ).slider({";
		$out.="value:" . $value . ",";
		$out.="min: " . $min . ",";
		$out.="max: " . $max . ",";
		$out.="step: " . $step . ",";
		$out.="slide: function( event, ui ) {";
		$out.="$( \"#" . $id . "\" ).val( \"\" + ui.value );";
		$out.="}";
		$out.="});";
		$out.="$( \"#" . $id . "\" ).val( \"\" + $( \"#" . $id . "_slider\" ).slider( \"value\" ) );";
		$out.="});";
		$out.="</script>";
		return $out;
	}

	public static function rating($id, $min = 1, $max = 5, $split = false, $sel = "") {
		$out = "";
		$out .= "<div id='stars-$id'>";
		for ($x = $min; $x <= $max; $x++) {
			$select_v = ($sel && $x == $sel) ? " checked" : "";
			$uid = $id . "_" . $x;
			$out .= "<input type=\"radio\" id=\"$uid\" name=\"$id\" value=\"$x\" $select_v title=\"$x\"/>";
		}
		$sp = $split ? "{split:2}" : "";
		$out .= "</div>";
		$out .= "<script>";
		$out .= "$(function() {";
		$out .= "$(\"#stars-" . $id . "\").stars($sp);";
		$out .= "});";
		$out .= "</script>";
		return $out;
	}

	/*
	 * @deprecated
	 * Usar select
	 */

	public static function listbox($id, $sql, $default = 0, $all = "") {
		$connTemp = new db();
		$connTemp->open();
		$rs = new query($connTemp, $sql);
		$result = "<select name=\"$id\" id=\"$id\" size=\"1\">\n";
		if ($all != "") {
			$result .= "<option value=\"\">$all</option>\n";
		}
		while ($rs->getrow()) {
			$key = $rs->field($rs->fieldname(0));
			$val = substr($rs->field($rs->fieldname(1)), 0, 80);
			if ($default == $key) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$result .= "<option value=\"$key\" $selected>$val</option>\n";
		}
		$result .= "</select>\n";
		$connTemp->close();
		return $result;
	}

	/*
	 * @deprecated
	 * Usar select
	 */

	public static function memoryListbox($id, $lista, $default = 0, $all = "") {
		$result = "<select name=\"$id\" id=\"$id\" size=\"1\" >\n";
		if ($all != "") {
			$result .= "<option value=\"\">$all</option>\n";
		}
		while (list($key, $val) = each($lista)) {
			$string = explode(",", $val);
			$label = trim($string[1]);
			$value = trim($string[0]);
			if ($default == $value) {
				$selected = "selected";
			} else {
				$selected = "";
			}
			$result .= "<option value=\"$value\" $selected>$label</option>\n";
		}
		$result .= "</select>\n";
		return $result;
	}

}
