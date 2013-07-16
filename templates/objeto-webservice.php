<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnPesquisar", "Pesquisar");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", true);

// Form /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$form = new Form("frm","../templates/objeto-controller.php?action=ws","post");
$form->addField("Valor", Field::text("f_valor", "", "60"));
$form->addField("Resultado", Element::placeHolder("result",""));
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
					Buttons.disable();
					$('#result').html('Carregando, aguarde...');
					$.post("../templates/objeto-controller.php?action=ws", $("#frm").serialize(), resultCallback, "json");
				});
				
				// define foco no campo
				$('#f_valor').focus();

			});
			
			// função de callback do ajax
			function resultCallback(data) {
				if (data.ok == "1") {
					$("#result").html(data.valor.loginReturn);
				} else {
					Messages.error(data.erro);
				}
				Buttons.enable();
			}
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo de consumo webservice"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$form->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>