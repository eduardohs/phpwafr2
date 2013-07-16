<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnUpload", "Enviar");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", true);

// Formulário de upload
$form = new Form("frmUpload", "../templates/objeto-controller.php?action=upload", "post", false);
$form->setUpload(true);
$form->addField("Título:", Field::text("f_titulo", "", 50, 50));
$form->addField("Arquivo:", Field::file("f_arquivo", "documento.pdf", 30));
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnUpload").click(function() {
					$("#frmUpload").submit();
				});
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo de Upload"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$form->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>