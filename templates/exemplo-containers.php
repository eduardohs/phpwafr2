<?php
include_once("../inc/common.php");

// Controle de acesso
Security::verifyUser("feedback_consultar");

// Gerador de lorem ipsum
$lorem = new LoremIpsum();

// Botões
$button = new Button();
$button->add("btnBotao", "Botão");

// Accordion
$accordion = new Accordion("accordion", true);
$accordion->add("Seção Um", $lorem->getContent(100));
$accordion->add("Seção Dois", $lorem->getContent(150));
$accordion->add("Seção Três", $lorem->getContent(250));

// Abas
$aba = new MemoryTabs();
$aba->add("Aba Um",$lorem->getContent(100));
$aba->add("Aba Dois",$lorem->getContent(200));
$aba->add("Aba Três",$lorem->getContent(300));
$aba->add("Aba Quatro",$lorem->getContent(350));
$aba->add("Aba Cinco",$lorem->getContent(100));

$aba->add("Aba Accordion",$accordion->getHTML());


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
				$("#btnBotao").click(function() {
					Messages.success("Botão pressionado!");
				});
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplos de containers"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				
				Element::h3("Accordion");
				$accordion->writeHTML();
				
				Element::h3("Tabs");
				$aba->writeHTML();
				?>
			</div>
		</div>
    </body>
</html>