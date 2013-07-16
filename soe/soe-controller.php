<?php

include_once("../inc/common.php");

// Inicialização dos dados de saída /////////////////////////////////////////////////////////////////////////////////////
$result["ok"] = "0";

// Captura a ação a ser executada ///////////////////////////////////////////////////////////////////////////////////////
$action = Param::get("action");

// Login ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
if ($action == "login") {
	$msg_saida = "";
	$cod_erro = Param::get("COD_ERRO");
	$mensagem = Param::get("MENSAGEM");
	$cod_usuario = Param::get("COD_USUARIO");
	$ide_na_organizacao = Param::get("IDE_NA_ORGANIZACAO");
	$nome_usuario = Param::get("NOME_USUARIO");
	$cod_organizacao = Param::get("COD_ORGANIZACAO");
	$sigla_organizacao = Param::get("SIGLA_ORGANIZACAO");
	$sigla_setor = Param::get("SIGLA_SETOR");
	$soe_ticket = Param::get("SOE_TICKET");
	$emails = Param::get("EMAILS");
	$objetos = Param::get("OBJETOS");
	$nomeextobj = Param::get("NOMEEXTOBJ");
	$acoes = Param::get("ACOES");
	
	$captchaOk = true;
	if (isset($_REQUEST["f_captcha"])) {
		 if (strtoupper(Param::get("f_captcha")) !=strtoupper(Session::get("sis_captcha"))) {
			 $captchaOk = false;
			 $error->add("Código de verificação inválido");
		 }
	}

	if (($cod_erro == "0") && ($captchaOk)) {
		$result["ok"] = "1";

		Session::set("sis_username", $nome_usuario);
		Session::set("sis_cod_usuario", $cod_usuario);
		Session::set("sis_matricula", $ide_na_organizacao);
		Session::set("sis_organizacao", $sigla_organizacao);
		Session::set("sis_setor", $sigla_setor);
		Session::set("sis_ticket", $soe_ticket);
		Session::set("sis_acoes", $acoes);
		Session::set("sis_objetos", $objetos);
		Session::set("sis_emails", $emails);

		$msg_saida = "Login efetuado com sucesso.";
		//Messages::sendSuccess($msg_saida);
		Session::set("sis_captcha_tentativas",0);
		Http::redirect("../common/index.php");
	} else {
		Session::set("sis_cod_usuario", $cod_usuario);
		Session::set("sis_ticket", $soe_ticket);
		Session::set("sis_origem", "L");
		if ($cod_erro == "101") {
			$msg_saida = "O prazo da senha expirou!";
			Messages::sendError($msg_saida);
			Http::redirect("../soe/soe-senha-alteracao.php");
		} else {
			if ($cod_erro == "103")	$msg_saida = "Senha não informada";
			if ($cod_erro == "104")	$msg_saida = "Senha inválida";
			if ($cod_erro == "106")	$msg_saida = "Usuário não cadastrado";
			if ($cod_erro == "108")	$msg_saida = "Prazo do usuário expirou";
			if ($cod_erro == "120")	$msg_saida = "Prazo expirou por inatividade";
			if ($cod_erro == "121")	$msg_saida = "Matrícula não informada";
			if ($cod_erro == "202")	$msg_saida = "Organização não informada";
			if ($cod_erro == "1901") $msg_saida = "Erro na atualização do prazo de operação do usuário";
			if ($cod_erro == "9999") $msg_saida = "Erro no ambiente";
			Session::set("sis_captcha_tentativas",intval(Session::get("sis_captcha_tentativas"))+1);
		}
		Messages::sendError($msg_saida);
		Http::redirect("../soe/soe-login.php");
	}
}
?>