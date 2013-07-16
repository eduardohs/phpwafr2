<?php
include_once("../inc/common.php");

// Controle de acesso ////////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUserInPopup("feedback_consultar");

// Processa seleção dos registros (insert na entidade fraca) /////////////////////////////////////////////////////////////
if (Param::get("frmSubmitted") == "sim") {
	$list = Param::getArray("sel");
	if (sizeof($list)==0) {
		Messages::sendError("Nenhum registro selecionado");
	} else {
		$db = new DBH();
		for ($x = 0; $x < sizeof($list); $x++) {
			$id = $list[$x];
			$rows = array (
				"usuario_id" => Session::get("lovFkId"),
				"sistema_id" => $id,
				"ordem_exibicao" => 0
			);
			$db->insert("sistema_usuario", $rows);
		}
		$db = null;
		Messages::sendSuccess("Registros associados");
	}
	JS::loadiFrame("../templates/objeto-mlov.php");
	die();
}

// Persiste chave do relacionamento //////////////////////////////////////////////////////////////////////////////////////
if (Param::getInt("fk_id") > 0) {
	$fk_id = Param::get("fk_id");
	Session::set("lovFkId", $fk_id);
}

// Construção da pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
if (Param::get("executed") == "s") { // se ocorreu pesquisa...
	$where = "";
	if (Param::get("f_busca") != "") $where .= "AND sistema.nome_sistema LIKE '%" . Param::get("f_busca") . "%'";
}

// Expressão SQL que define a lista //////////////////////////////////////////////////////////////////////////////////////
$sqlNotIn = "SELECT sistema_id FROM sistema_usuario WHERE usuario_id=" . Session::get("lovFkId");
$sql = "SELECT * "
		. "FROM sistema "
		. "WHERE sistema_id NOT IN (" . $sqlNotIn . ") " . $where . "ORDER BY nome_sistema ASC";

// Criação do recordset //////////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql, 300);

// Formulário de pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
$form = new Form("frmSearchLov", "", "GET", false);
$form->addField(Field::text("f_busca", Param::get("f_busca"), 12, 50), Button::quickButton("btnOk", "Pesquisar").Button::quickButton("btnSelecionar", "Selecionar").Button::quickButton("btnFechar", "Fechar"));

// Lista de dados ////////////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("frm", 2);
$table->addHidden("frmSubmitted", "sim");
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Nome do Sistema", false, "100%");
foreach ($rows as $row) {
	$id = $row["sistema_id"];
	$table->addCheckboxData($id);
	$table->addDataLabel($id, $row["nome_sistema"]);
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
					$("#frmSearchLov").attr("action","../templates/objeto-mlov.php");
					$("#frmSearchLov").submit();
				});

				// ação do botão Selecionar
				$("#btnSelecionar").click(function() {
					$("#frm").attr("action","../templates/objeto-mlov.php");
					$("#frm").submit();
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					iframePopup.reload();
				});

				// highlight ao passar o mouse
				Tables.setHighlightOnHover(true);

				// highlight ao selecionar
				Tables.setHighlightOnSelect(true);

				// define qual botão é acionado ao pressionar Enter
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