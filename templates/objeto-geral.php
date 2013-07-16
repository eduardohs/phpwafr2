<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnBotao", "Botão");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", true);

// Box de exemplo ///////////////////////////////////////////////////////////////////////////////////////////////////////
$box = new Box("Título");
$box->add("Olá mundo");
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
			<?php Element::header("Página Genérica"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$box->writeHTML();
				?>
			</div>
		</div>
    </body>
</html>