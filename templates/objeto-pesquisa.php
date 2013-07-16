<?php
include_once("../inc/common.php");

// Controle de acesso
Security::verifyUser("feedback_consultar");

// Botões
$button = new Button();
$button->add("btnPesquisar", "Pesquisar");
$button->add("btnNovo", "Novo");
$button->add("btnFechar", "Fechar");

// Formulário de pesquisa
$form = new Form("frmPesquisa", "../templates/objeto-lista.php", "post", false);
$form->addField("Nome do usuário", Field::text("f_nome_usuario", "", 20, 20));
$form->addField("Nome real", Field::text("f_nome_real", "", 50, 50));
$rowsDepartamento = DBH::getRows("SELECT departamento_id as id, nome_departamento as label FROM departamento ORDER BY nome_departamento");
$form->addField("Departamento", Field::select("f_departamento_id", $rowsDepartamento, 0, "Todos"));
$form->addField("Intervalo Data", Field::textInterval("f_data",11,10));
$form->addField("Intervalo", Field::textInterval("f_texto", 20, 20));
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				// ação do botão Pesquisar
				$("#btnPesquisar").click(function() {
					$("#frmPesquisa").submit();
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					location = "../templates/objeto-lista.php";
				});

				// ação do botão Novo
				$("#btnNovo").click(function() {
					location = "../templates/objeto-edicao.php";
				});

				// adicionar detepicker nos campos de data
				$("#f_data_1").datepicker();
				$("#f_data_2").datepicker();

				// foco no campo
				$("#f_nome_usuario").focus();

				// define qual botão é acionado ao pressionar Enter
				Buttons.mapEnterKey("btnPesquisar");
			});

		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Pesquisar Objetos"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$form->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>