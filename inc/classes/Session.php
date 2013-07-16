<?php

class Session {

	public static function get($param_name) {
		return $_SESSION[$param_name];
	}

	public static function set($param_name, $param_value) {
		$_SESSION[$param_name] = $param_value;
	}

	public static function clearFilter() {
		if (Param::getInt("clear") == 1) {
			Session::set("sOrder", "");
			Session::set("sWhere", "");
			Session::set("current_page", "");
		}
	}

	public static function handleCurrentPage() {
		$samepage = false;
		if ($_SERVER['PHP_SELF'] != Session::get("current_page")) {
			$samepage = false;
			Session::set("current_page", $_SERVER['PHP_SELF']);
		} else {
			$samepage = true;
		}
		return $samepage;
	}

	public static function writeWhereStatus() {
		$filtered = "";
		if (strlen(Session::get("sWhere")) > 0) {
			$filtered = "<div onclick='divShowHide(\"more-text\")' class='ui-state-highlight ui-corner-all clicavel' id='div-table-filtered'><div style='float: left; margin-right: 10px' class='ui-icon ui-icon-info'></div><div style='float: right; position: relative'><a class='link' href='" . $_SERVER['PHP_SELF'] . "?clear=1'><img src='../img/icon-fechar.gif' title='Limpar critério de pesquisa'></a></div>Filtro ativo<div id='more-text' style='display: none;' >".Session::get("sMensagemWhere")."</div></div>";
		} else {
			$filtered = "";
		}
		echo $filtered;
	}

	public static function handleLov() {
		if (strlen(Param::get("nome_campo")) > 0) {
			$nome_campo = Param::get("nome_campo");
			Session::set("lovNomeCampo", $nome_campo);
		}
	}

	public static function getCampoLov() {
		return Session::get('lovNomeCampo');
	}

}

