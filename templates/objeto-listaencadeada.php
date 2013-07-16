<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Limpa ordenação e filtro ////////////////////////////////////////////////////////////////////////////////////////
Session::clearFilter();

// Ordenação ///////////////////////////////////////////////////////////////////////////////////////////////////////
$order = new OrderBy();
$order->add(2, "order by usuario.nome_real");
$order->setDefaultOrder(2);
$order->handleOrder();

// Construção da pesquisa //////////////////////////////////////////////////////////////////////////////////////////
$where = new Where();
$where->add("Nome de usuário contém '*'", "AND usuario.nome_usuario LIKE '%*%'", Param::get("f_nome_usuario"), Param::get("f_nome_usuario") != "");
$where->add("Nome real contém '*'", "AND usuario.nome_real LIKE '%*%'", Param::get("f_nome_real"), Param::get("f_nome_real") != "");
$where->add("Código de departamento = *", "AND usuario.departamento_id=*", Param::getInt("f_departamento_id"), Param::getInt("f_departamento_id") > 0);
$where->handleWhere();

// Expressão SQL que define a lista ////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT usuario.* " .
		"FROM usuario " .
		"WHERE 1=1 " .
		$where->getWhere() .
		$order->getOrderBy();

// Criação do resultset ////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql);

// Deck de botões //////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnPesquisa", "Pesquisa");

// Lista de dados //////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("lista", 2);
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Nome Real", true, "100%", "L");


foreach($rows as $row) {
	$id = $row["usuario_id"];

	$table->addCheckboxData($id);
	$table->addData(Folding::link($id, $row["nome_real"], "../templates/objeto-controller.php?action=carregatree&id=".$id));
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
				// ação do botão Pesquisa
				$("#btnPesquisa").click(function() {
					location = "../templates/objeto-pesquisa.php";
				});
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Lista de Objetos Encadeados"); ?>
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