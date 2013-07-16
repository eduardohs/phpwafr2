<?php
include_once("../inc/common.php");

// Controle de acesso ////////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUserInPopup("feedback_consultar");

// Construção da pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
if (Param::get("executed") == "s") { // se ocorreu pesquisa...
	$where = "";
	if (Param::get("f_busca") != "")
		$where .= "AND sistema.nome_sistema LIKE '%" . Param::get("f_busca") . "%'";
}

// Expressão SQL que define a lista //////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM sistema WHERE 1=1 " . $where . " ORDER BY nome_sistema ASC";

// Criação do recordset //////////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql, 300);

// Formulário de pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
$form = new Form("frmSearchLov", "", "GET", false);
$form->addField(Field::text("f_busca", Param::get("f_busca"), 12, 50), Button::quickButton("btnOk", "Pesquisar") . Button::quickButton("btnSelecionar", "Selecionar") . Button::quickButton("btnFechar", "Fechar"));

// Lista de dados ////////////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("frm", 2);
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Nome do Sistema", false, "100%");
foreach ($rows as $row) {
	$id = $row["sistema_id"];
	$table->addCheckboxData($id);
	$table->addDataLabel($id, $row["nome_sistema"], true);
}
?>
<!DOCTYPE html>
<html>
	<head>
<?php Element::headBlock(); ?>
		<script type="text/javascript">
			$(document).ready(function() {
				// foco no campo
				$("#f_busca").focus();

				// ação do botão OK
				$("#btnOk").click(function() {
					$("#frmSearchLov").attr("action","../templates/objeto-listboxlov.php");
					$("#frmSearchLov").submit();
				});

				// ação do botão Selecionar
				$("#btnSelecionar").click(function() {
					ListboxLov.transfer("f_listboxlov");
					iframePopup.close();
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					iframePopup.close();
				});

				// highlight ao passar o mouse
				Tables.setHighlightOnHover(true);

				// highlight ao selecionar
				Tables.setHighlightOnSelect(true);

				// define qual botão será acionado ao pressionar Enter
				Buttons.mapEnterKey("btnOk");
			});
		</script>
	</head>
	<body>
		<div id="container">
			<?php Element::headerLov("Selecione o(s) objeto(s)"); ?>
			<div id="acoes"><?php $form->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$table->writeHTML();
				Paging::writeQtdeReg(sizeof($rows));
				?>
			</div>
		</div>
	</body>
</html>