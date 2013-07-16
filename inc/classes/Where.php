<?php
class Where {
	private $where;
	private $mensagens;
	
	public function Where() {
		$this->where = "";
		$this->mensagens = "<ul>";
	}
	
	public function add($msg, $expr, $valor, $criterio) {
		if ($criterio) {
			$this->mensagens .= "<li>".str_replace("'","´",str_replace("*",$valor,$msg))."</li>";
			$this->where .= " ".str_replace("*",$valor,$expr);
		}
	}

	public function handleWhere() {
		if (Param::get("executed") == "s") {
			Session::set("sWhere", $this->where);
			Session::set("sMensagemWhere", $this->mensagens . "</ul>");
		}
	}
	
	public function getWhere() {
		return Session::get("sWhere");
	}
	
	public function getMensagemFiltro() {
		return Session::get("sMensagemWhere");
	}

}
