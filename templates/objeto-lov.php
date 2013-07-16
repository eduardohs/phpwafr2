<?php
include_once("../inc/common.php");

// Controle de acesso ////////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUserInPopup("feedback_consultar");

// Persiste o nome do campo a ser populado ///////////////////////////////////////////////////////////////////////////////
Session::handleLov();

// Construção da pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
if (Param::get("executed") == "s") { // se ocorreu pesquisa...
	$where = "";
	// construa a string WHERE conforme o exemplo abaixo
	if (Param::get("f_busca") != "") $where .= "AND usuario.nome_real LIKE '%" . Param::get("f_busca") . "%'";
}


// Expressão SQL que define a lista //////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT usuario.*, departamento.nome_departamento "
		. "FROM usuario, departamento "
		. "WHERE usuario.departamento_id=departamento.departamento_id " . $where . "ORDER BY usuario.nome_real ASC";


// Criação do recordset //////////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql, 300);

// Formulário de pesquisa ////////////////////////////////////////////////////////////////////////////////////////////////
$form = new Form("frmSearchLov", "", "get", false);
$form->addField(Field::text("f_busca", Param::get("f_busca"), 30, 50),Button::quickButton("btnOk", "Pesquisar").Button::quickButton("btnSelecionar", "Selecionar").Button::quickButton("btnFechar", "Fechar"));

// Lista de dados ////////////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("frm", 6);
$table->addColumnHeader();
$table->addColumnHeader("Usuário", false, "25%"); // Título, Ordenar?, Largura
$table->addColumnHeader("Nome Real", false, "35%");
$table->addColumnHeader("Nivel", false, "10%", "C");
$table->addColumnHeader("Departamento", false, "20%");
$table->addColumnHeader("Ativo", false, "10%", "C");

foreach ($rows as $row) {
	$id = $row["usuario_id"];

	$table->addRadioData($id);
	$table->addDataLabel($id, $row["nome_usuario"]);
	$table->addDataLabel($id, $row["nome_real"], true); // TRUE para transferir o valor
	$table->addDataLabel($id, $row["nivel_acesso"], false, "C");
	$table->addDataLabel($id, $row["nome_departamento"]);
	$table->addDataLabel($id, Format::simNao($row["ativo"]), false, "C");
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
					$('#frmSearchLov').action = "../templates/objeto-lov.php";
					$('#frmSearchLov').submit();
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					iframePopup.close();
				});

				// ação do botão Selecionar
				$("#btnSelecionar").click(function() {
					if (Lov.isSelected()) {
						Lov.transfer("<?php echo Session::getCampoLov(); ?>");
						iframePopup.close();
					} else {
						Messages.error("Selecione um registro");
					}
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
			<?php Element::headerLov("Selecione o objeto"); ?>
			<div id="acoes">
				<?php $form->writeHTML(); ?>
			</div>
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