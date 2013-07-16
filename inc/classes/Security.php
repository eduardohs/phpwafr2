<?php
class Security {

	public static function validateLogin($usuario, $senha) {
		// implementar...
	}

	public static function verifyUser($nivel = "") {
		if (AUTH_PRODUCAO) {
			if (AUTH_SOE) {
				if (isset($_SESSION["sis_username"])) {
					$pos = strpos(strtoupper($_SESSION['sis_acoes']), strtoupper($nivel));
					if ($pos === false) {
						Messages::sendError("Você não possui permissão para acessar a página solicitada.");
						Http::redirect("../soe/soe-login.php");
					}
				} else {
					Http::redirect("../soe/soe-login.php");
				}
			} else {
				if (intval($nivel) >= 0) {
					if (Session::get("sis_apl") != SYS_APL_NAME) {
						Http::redirect("../common/login.php");
					} else
					if ((!isset($_SESSION["sis_level"]) || Session::get("sis_level") < intval($nivel))) {
						Http::redirect("../common/login.php?querystring=" . urlencode(getenv("QUERY_STRING")) . "&ret_page=" . urlencode(getenv("REQUEST_URI")));
					}
				}
			}
		}
	}

	public static function isValidUser($level = "") {
		if (AUTH_PRODUCAO) {
			if (strlen($level) == 0)
				return true;
			if (AUTH_SOE) {
				$pos = strpos(strtoupper($_SESSION['sis_acoes']), strtoupper($level));
				if ($pos === false) {
					return false;
				} else {
					return true;
				}
			} else {
				return ((intval($level) == 0) || (Session::get("sis_level") >= intval($level)));
			}
		} else {
			return true;
		}
	}

	public static function verifyUserInPopup($level = "") {
		if (!Security::isValidUser($level)) {
			echo "Você não tem permissão para acessar esta página.";
			die();
		}
	}

	public static function isLoginOk() {
		return $_SESSION['sis_login'] == "OK";
	}

	public static function getUser() {
		return $_SESSION['sis_username'];
	}

	public static function getLevel() {
		if (AUTH_SOE) {
			return $_SESSION["acoes"];
		} else {
			return $_SESSION['sis_level'];
		}
	}

}
