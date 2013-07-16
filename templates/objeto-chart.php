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

// Box com os gráficos //////////////////////////////////////////////////////////////////////////////////////////////////
$horizontal = new Box("Horizontal Bar");
$horizontal->add(Element::image("../templates/chart-controller.php?action=horizontal"));

$vertical = new Box("Vertical Bar");
$vertical->add(Element::image("../templates/chart-controller.php?action=vertical"));

$line = new Box("Line");
$line->add(Element::image("../templates/chart-controller.php?action=line"));

$multipleHorizontal = new Box("Multiple Horizontal");
$multipleHorizontal->add(Element::image("../templates/chart-controller.php?action=multiplehorizontalbar"));

$multipleLine = new Box("Multiple Line");
$multipleLine->add(Element::image("../templates/chart-controller.php?action=multipleline"));

$multipleVerticalBar = new Box("Multiple Vertical Bar");
$multipleVerticalBar->add(Element::image("../templates/chart-controller.php?action=multipleverticalbar"));

$pie = new Box("Pie");
$pie->add(Element::image("../templates/chart-controller.php?action=pie"));

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
			<?php Element::header("Exemplo de gráficos"); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$horizontal->writeHTML();
				$vertical->writeHTML();
				$line->writeHTML();
				$multipleHorizontal->writeHTML();
				$multipleLine->writeHTML();
				$multipleVerticalBar->writeHTML();
				$pie->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>