<?php

include_once("../inc/common.php");

// Tratamento de campos
$fusername = Param::get("f_username");
$fpassword = Param::get("f_password");

// Controle de fluxo de página
$ret_page = Param::get("ret_page");
if ($ret_page == "")
	$ret_page = "../common/index.php";

// Validação
$error = new Error();
if ($fusername == "")
	$error->add("Nome de usuário deve ser informado");
if ($fpassword == "")
	$error->add("Senha deve ser informda");

// Validação de captcha
if (isset($_POST["f_captcha"])) {
	 if (strtoupper(Param::get("f_captcha")) !=strtoupper(Session::get("sis_captcha"))) {
		 $error->add("Código de verificação inválido");
	 }
}

// se passou na validação...
if (!$error->hasError()) {
	$db = new DBH();
	$bind = array(
		":user" => $fusername,
		":password" => $fpassword
	);
	$rs = $db->select(AUTH_TABLE, AUTH_WHERE, $bind);
	$db = null;

	if (sizeof($rs)>0) { // se entrou...
		Session::set("sis_username", $rs[0][AUTH_USERNAME]);
		Session::set("sis_username_old", $rs[0][AUTH_USERNAME]);
		Session::set("sis_level", $rs[0][AUTH_LEVEL]);
		Session::set("sis_apl", SYS_APL_NAME);
		Session::set("sis_captcha_tentativas",0);
		$target_page = $ret_page;

	} else { // se não entrou...
		$error->add("Usuário ou senha inválidos");
		Session::set("sis_captcha_tentativas",intval(Session::get("sis_captcha_tentativas"))+1);
		$target_page = "../common/login.php";
	}
// não passou na validação...
} else {
	$target_page = "../common/login.php";
}
Messages::sendError($error->toString());
header("Location: $target_page");
?>