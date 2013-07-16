<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// captura chave do relacionamento /////////////////////////////////////////////////////////////////////////////////
$fk_id = Param::getInt("id");

// Expressão SQL que define a lista ////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT * " .
		"FROM historico " .
		"WHERE usuario_id=$fk_id " .
		"ORDER BY data_cadastro DESC";

// Criação do recordset ////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql);

// Deck de botões //////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnNovo", "Novo");
$button->add("btnExcluir", "Excluir");
$button->add("btnFechar", "Fechar");

// Abas ////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", false, "../templates/objeto-edicao.php?id=" . $fk_id);
$tabs->add("Associação N:N", false, "../templates/objeto-associacao.php?id=" . $fk_id);
$tabs->add("Detalhe", false, "../templates/objeto-consulta.php?id=" . $fk_id);
$tabs->add("Lista 1:N", true);

// Lista de dados /////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("frmLista", 3);
$table->addHidden("fk_id", $fk_id);
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Data", false, "15%");
$table->addColumnHeader("Descrição", false, "85%");

foreach ($rows as $row) {
	$id = $row["historico_id"];

	$table->addCheckboxData($id);
	$table->addData(Dates::format($row["data_cadastro"]));
	$table->addData(Element::link($row["descricao"], "javascript:abreEdicao($id)", "Clique aqui para editar o registro"));
}
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				// ação do botão Novo
				$("#btnNovo").click(function() {
					abreEdicao(0);
				});

				// ação do botão Excluir
				$("#btnExcluir").click(function() {
					Dialog.confirm("Confirma exclusão dos registros selecionados?", function() {
						$("#frmLista").attr("action","../templates/objeto-controller.php?action=excluir1n");
						$("#frmLista").submit();
					}, "Exclusão");
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

			// abre popup de edição do relacionamento
			function abreEdicao(id) {
				iframePopup.open("../templates/objeto-edicao-aux.php?fk_id=<?php echo $fk_id; ?>&id=" + id, 500, 300);
			}
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Lista de Objetos"); ?>
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