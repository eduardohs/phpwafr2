<?php
include_once("../inc/common.php");
Session::set("sis_username","");
Session::set("sis_level","");
Session::set("sis_apl","");
Session::set("sis_cod_usuario", "");
Session::set("sis_matricula", "");
Session::set("sis_organizacao", "");
Session::set("sis_setor", "");
Session::set("sis_ticket", "");
Session::set("sis_acoes", "");
Session::set("sis_objetos", "");
Session::set("sis_emails", "");

unset($_SESSION["sis_username"]);
unset($_SESSION["sis_level"]);
unset($_SESSION["sis_apl"]);
unset($_SESSION["sis_cod_usuario"]);
unset($_SESSION["sis_matricula"]);
unset($_SESSION["sis_organizacao"]);
unset($_SESSION["sis_setor"]);
unset($_SESSION["sis_ticket"]);
unset($_SESSION["sis_acoes"]);
unset($_SESSION["sis_objetos"]);
unset($_SESSION["sis_emails"]);

unset($_SESSION["sis_captcha"]);
unset($_SESSION["sis_captcha_tentativas"]);

unset($_SESSION["sis_tema"]);

header("Location: ../common/index.php");
?>