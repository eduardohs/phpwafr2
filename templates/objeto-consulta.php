<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Tratamento de campos ////////////////////////////////////////////////////////////////////////////////////////////////
$id = Param::getInt("id"); // captura a chave
if ($id > 0) { // edição
	$sql = "SELECT * FROM usuario WHERE usuario_id=" . $id;
	$row = DBH::getrow($sql);
	if (sizeof($row) > 0) {
		$bd_usuario_id = $row["usuario_id"];
		$bd_data_cadastro = Dates::format($row["data_cadastro"]);
		$bd_nome_usuario = $row["nome_usuario"];
		$bd_nivel_acesso = $row["nivel_acesso"];
		$bd_nome_real = $row["nome_real"];
		$bd_departamento_id = $row["departamento_id"];
		$bd_email = $row["email"];
		$bd_descricao = $row["descricao"];
		$bd_ativo = $row["ativo"];
		$bd_sistemas = DBH::getRows("SELECT sistema.nome_sistema FROM sistema, sistema_usuario WHERE sistema.sistema_id=sistema_usuario.sistema_id AND sistema_usuario.usuario_id=".$bd_usuario_id);
	}
}

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnFechar", "Fechar");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", false, "../templates/objeto-edicao.php?id=".$id);
$tabs->add("Associação N:N", false, "../templates/objeto-associacao.php?id=" . $id);
$tabs->add("Detalhe", true);
$tabs->add("Lista 1:N", false, "../templates/objeto-lista-1n.php?id=" . $id, "feedback_consultar");

// Formulário ///////////////////////////////////////////////////////////////////////////////////////////////////////////
$view = new View();
$view->setAutoNewLine(false);
$view->addData("Data de cadastro", $bd_data_cadastro);
$view->addData("Nome do usuário", $bd_nome_usuario);
$view->addData("Nível de acesso", $bd_nivel_acesso);
$view->newLine();

$view->addData("Nome real", $bd_nome_real);
$view->addData("E-mail", $bd_email);
$view->newLine();

$view->addData("Departamento", DBH::getColumn("SELECT nome_departamento FROM departamento WHERE departamento_id=" . $bd_departamento_id));
$view->addData("Descrição", $bd_descricao);
$view->newLine();

$view->addBreak("Exemplo de quebra");

$view->addData("Ativo", Format::simNao($bd_ativo));
$view->newLine();

$view->addBreak("Sistemas");
foreach ($bd_sistemas  as $row) $sistema .= $row["nome_sistema"]."<br/>";
$view->addData("Sistemas", $sistema);
$view->newLine();
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					location = "../templates/objeto-lista.php";
				});

			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Consulta de Objeto"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$view->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>