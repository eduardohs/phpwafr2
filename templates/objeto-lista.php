<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Limpa ordenação e filtro ////////////////////////////////////////////////////////////////////////////////////////
Session::clearFilter();

// Ordenação ///////////////////////////////////////////////////////////////////////////////////////////////////////
$order = new OrderBy();
$order->add(2, "order by usuario.nome_usuario");
$order->add(3, "order by usuario.nome_real");
$order->add(4, "order by usuario.nivel_acesso");
$order->add(5, "order by departamento.nome_departamento");
$order->add(7, "order by usuario.data_cadastro");
$order->setDefaultOrder(2);
$order->handleOrder();

// Construção da pesquisa //////////////////////////////////////////////////////////////////////////////////////////
$where = new Where();

$where->add("Nome de usuário contém '*'", "AND usuario.nome_usuario LIKE '%*%'", Param::get("f_nome_usuario"), Param::get("f_nome_usuario") != "");
$where->add("Nome real contém '*'", "AND usuario.nome_real LIKE '%*%'", Param::get("f_nome_real"), Param::get("f_nome_real") != "");

$txtDep = DBH::getColumn("SELECT nome_departamento FROM departamento WHERE departamento_id=" . Param::getInt("f_departamento_id"));
$where->add("Departamento = " . $txtDep, "AND usuario.departamento_id=*", Param::getInt("f_departamento_id"), Param::getInt("f_departamento_id") > 0);

$where->handleWhere();

// Expressão SQL que define a lista ////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT usuario.*, departamento.nome_departamento " .
		"FROM usuario, departamento " .
		"WHERE usuario.departamento_id=departamento.departamento_id" .
		$where->getWhere() .
		$order->getOrderBy();

// Criação do resultset ////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql);

// Deck de botões //////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnNovo", "Novo");
$button->add("btnPesquisa", "Pesquisa");
$button->add("btnExcluir", "Excluir");
$button->add("btnProcessar", "Processar", "feedback_consultar");
$button->add("btnImprimir", "Imprimir");
$button->add("btnXls", "Exportar");

// Lista de dados //////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("lista",8);
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Usuário", true, "20%", "L"); // Título, Ordenar?, Largura, Alinhamento
$table->addColumnHeader("Nome Real", true, "25%", "L");
$table->addColumnHeader("Nivel", true, "10%", "C");
$table->addColumnHeader("Departamento", true, "15%", "L");
$table->addColumnHeader("Ativo", false, "10%", "C");
$table->addColumnHeader("Cadastro", true, "10%", "C");
$table->addColumnHeader("Sistemas", false, "5%", "C");

$oldDep = "";

foreach ($rows as $row) {
	$id = $row["usuario_id"];

	$linkEdicao = new Link($row["nome_usuario"], "../templates/objeto-edicao.php", "Clique para editar o registro");
	$linkEdicao->addParameter("id", $id);

	if ($order->getCurrentOrder() == 5) { // exemplo de quebra
		if ($oldDep != $row["nome_departamento"]) {
			$table->addBreak($row["nome_departamento"]);
			$oldDep = $row["nome_departamento"];
		}
	}

	$table->addCheckboxData($id);
	$table->addData($linkEdicao->getLink());
	$table->addData($row["nome_real"]);
	$table->addData($row["nivel_acesso"], "C", false, "#FF0000");
	$table->addData($row["nome_departamento"]);
	$table->addData(Format::simNao($row["ativo"]), "C", $row["ativo"] == 1);
	$table->addData(Dates::format($row["data_cadastro"]), "C");
	$table->addData(Element::clickShow("Detalhe", "../templates/objeto-controller.php?action=carregatree&id=" . $id, 400, 200), "C");
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
					location = "../templates/objeto-edicao.php";
				});

				// ação do botão Pesquisa
				$("#btnPesquisa").click(function() {
					location = "../templates/objeto-pesquisa.php";
				});

				// ação do botão Excluir
				$("#btnExcluir").click(function() {
					Dialog.confirm("Confirma exclusão dos registros selecionados?", function() {
						$("#lista").attr("action","../templates/objeto-controller.php?action=excluir");
						$("#lista").submit();
					}, "Exclusão");

				});

				// ação do botão Processar
				$("#btnProcessar").click(function() {
					Dialog.confirm("Confirma processamento dos registros selecionados?",function() {
						$("#lista").attr("action","../templates/objeto-controller.php?action=processar");
						$("#lista").submit();
					}, "Processamento");
				});

				// ação do botão Imprimir
				$("#btnImprimir").click(function() {
					Dialog.confirm("Confirma impressão da lista?", function() {
						location = "../templates/objeto-imprimir.php";
					});
				});

				// ação do botão Exportar
				$("#btnXls").click(function() {
					location = "../templates/objeto-xls.php";
				});

				// highlight ao passar o mouse
				Tables.setHighlightOnHover(true);

				// highlight ao selecionar
				Tables.setHighlightOnSelect(true);

				// exibe a caixa de critérios
				expandCriteria();

				// liga filtro
				Tables.showFilter("lista");
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Lista de Objetos"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				Session::writeWhereStatus();
				$table->writeHTML();
				Paging::writeQtdeReg(sizeof($rows));
				?>
			</div>
		</div>

    </body>
</html>