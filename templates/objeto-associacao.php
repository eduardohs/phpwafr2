<?php
include_once("../inc/common.php");

// Controle de acesso ////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Captura chave do relacionamento ///////////////////////////////////////////////////////////////////////////////////
$fk_id = Param::getInt("id");

// Expressão SQL da lista ////////////////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT sistema.nome_sistema, sistema_usuario.* " .
		"FROM sistema_usuario, sistema " .
		"WHERE sistema.sistema_id=sistema_usuario.sistema_id " .
		"AND usuario_id=" . $fk_id .
		" ORDER BY sistema.nome_sistema ASC";

// Criação do recordset //////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql);

// Deck de botões ////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnAdicionar", "Adicionar");
$button->add("btnRemover", "Remover");
$button->add("btnFechar", "Fechar");

// Abas //////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", false, "../templates/objeto-edicao.php?id=" . $fk_id);
$tabs->add("Associação N:N", true);
$tabs->add("Detalhe", false, "../templates/objeto-consulta.php?id=" . $fk_id);
$tabs->add("Lista 1:N", false, "../templates/objeto-lista-1n.php?id=" . $fk_id);

// Lista de dados ////////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("frmLista", 2);
$table->addHidden("fk_id", $fk_id);
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Nome do Sistema", false, "100%");
foreach ($rows as $row) {
	$id = $row["sistema_id"];
	$table->addCheckboxData($id);
	$table->addData($row["nome_sistema"]);
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function() {
				// ação do botão Adicionar
				$("#btnAdicionar").click(function() {
					lovm("../templates/objeto-mlov.php?clear=1&fk_id=<?php echo $fk_id; ?>", 550);
				});

				// ação do botão Remover
				$("#btnRemover").click(function() {
					Dialog.confirm("Confirma remoção dos objetos selecionados?", function() {
						$("#frmLista").attr("action","../templates/objeto-controller.php?action=remover");
						$("#frmLista").submit();
					});
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					location = "../templates/objeto-lista.php?<?php echo $_SERVER['QUERY_STRING']; ?>";
				});

				// highlight ao passar o mouse
				Tables.setHighlightOnHover(true);

				// highlight ao selecionar
				Tables.setHighlightOnSelect(true);
			});
		</script>
	</head>
	<body>
		<div id="container">
			<?php Element::header("Associação N:N"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
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