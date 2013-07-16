<?php
include_once("../inc/common.php");

// Controle de acesso /////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Transação //////////////////////////////////////////////////////////////////////////////////////////////////////////
$xls = new ExcelExport();
$xls->addRow(Array("usuario_id", "nome_usuario", "data_cadastro", "nivel_acesso", "nome_real"));
$sql = "SELECT usuario_id, nome_usuario, data_cadastro, nivel_acesso, nome_real " .
		"FROM usuario " .
		"ORDER BY nome_usuario ASC";
$rows = DBH::getRows($sql);
foreach ($rows as $row) {
	$xls->addRow(Array($row["usuario_id"],
		$row["nome_usuario"],
		$row["data_cadastro"],
		$row["nivel_acesso"],
		$row["nome_real"]));
}
$xls->download("usuarios.xls");
?>
