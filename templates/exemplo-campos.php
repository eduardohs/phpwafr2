<?php
include_once("../inc/common.php");

// Controle de acesso
Security::verifyUser("feedback_consultar");

// Botões
$button = new Button();
$button->add("btnBotao", "Botão");

// Formulário de pesquisa
$form = new Form("frm", "../templates/objeto-lista.php", "post", false);
$form->addField("Slider", Field::slider("f_slider", 25, 0, 100, 5));
$form->addField("Rating", Field::rating("f_rating",1,10,true,4));
$form->addField("Rich Text", Field::richTextEditor("f_textarea","Teste"));
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		Element::loadRichTextEditor();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				// ação do botão Pesquisar
				$("#btnBotao").click(function() {
					Messages.success("Botão pressionado!");
				});
				
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplos de campos"); ?>
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