<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Limpa ordenação e filtro ////////////////////////////////////////////////////////////////////////////////////////
Session::clearFilter();

// Construção da pesquisa //////////////////////////////////////////////////////////////////////////////////////////
$where = new Where();
$where->add("Nome de usuário contém '*'", "AND usuario.nome_usuario LIKE '%*%'", Param::get("f_nome_usuario"), Param::get("f_nome_usuario") != "");
$where->add("Nome real contém '*'", "AND usuario.nome_real LIKE '%*%'", Param::get("f_nome_real"), Param::get("f_nome_real") != "");
$where->add("Código de departamento = *", "AND usuario.departamento_id=*", Param::getInt("f_departamento_id"), Param::getInt("f_departamento_id") > 0);
$where->handleWhere();

// Expressão SQL que define a lista ////////////////////////////////////////////////////////////////////////////////
$sql = "SELECT usuario.*, departamento.nome_departamento " .
		"FROM usuario, departamento " .
		"WHERE usuario.departamento_id=departamento.departamento_id " .
		$where->getWhere() .
		" order by usuario.nome_usuario";

// Criação do resultset ////////////////////////////////////////////////////////////////////////////////////////////
$rows = DBH::getRows($sql);

// Deck de botões //////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnBotao", "Botão");

// Lista de dados //////////////////////////////////////////////////////////////////////////////////////////////////
$grid = new Grid("grid", 5, "200px", "100px");
foreach ($rows as $row) {
	$grid->addItem($row["nome_usuario"]);
	$grid->addItem($row["nome_real"]);
	$grid->addItem($row["nivel_acesso"]);
	$grid->addItem($row["nome_departamento"]);
	$grid->addItem(Format::simNao($row["ativo"]));
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
				// ação do botão de exemplo
				$("#btnBotao").click(function() {
					Messages.success("Botão clicado com sucesso!");
				});
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Grid de Objetos"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				Session::writeWhereStatus();
				$grid->writeHTML();
				Paging::writeQtdeReg(sizeof($rows));
				?>
			</div>
		</div>

    </body>
</html>