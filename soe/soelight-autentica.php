<?php
include_once("../inc/common.php");
include_once("SoeLight.php");


$organizacao = Param::get("f_organizacao");
$sistema = Param::get("f_sistema");
$matricula = Param::get("f_matricula");

$soelight = new SoeLight($sistema, $matricula);

if ($soelight->autenticado()) {
	Session::set("sis_username", $matricula);
	Session::set("sis_cod_usuario", $matricula);
	Session::set("sis_matricula", $matricula);
	Session::set("sis_organizacao", $organizacao);
	Session::set("sis_setor", "ABC");
	Session::set("sis_acoes", $soelight->getAcoes());
	Session::set("sis_objetos", $soelight->getObjetos());
	Session::set("sis_emails", "pr".$matricula."@procergs.rs.gov.br");
	Http::redirect("../common/index.php");
} else {
	Messages::sendError("Erro ao autenticar no SOE Light");
	Http::redirect("../soe/soe-login.php");
}
?>
