<?php
include_once("../inc/common.php");

$botoes = new Button();
$botoes->add("btn1", "Botão Um");
$botoes->add("btn2", "Botão Dois");
$botoes->add("btn3", "Botão Três");

$botoesBox = new Button();
$botoesBox->add("btn4", "Ação 1");
$botoesBox->add("btn5", "Ação 2");
$botoesBox->add("btn6", "Ação 3");

$boxWelcome = new Box("Bem-vindo");
if (strlen(Security::getUser()) > 0) {
	$boxWelcome->add("Olá <strong>" . Security::getUser() . "</strong>, bem-vindo ao phpWAFr2, aproveite a ferramenta e tenha mais tempo livre!");
} else {
	$boxWelcome->add("Faça o login e descubra os recursos do phpWAFr, o framework para desenvolvimento de aplicações em PHP!");
}
$boxWelcome->setButtons($botoesBox);

$boxLogo = new Box("phpWAFr2");
$boxLogo->add("<div style='width: 100%; text-align: center; margin: 0px 0 0px 0;'><img src='../img/phpwafr.png' /></div>");

$multipleLine = new Box("Exemplo de Box");
$multipleLine->add(Element::image("../templates/chart-controller.php?action=multipleline", "", "500px"));

$layout = new Layout();
$layout->add("welcome", $boxWelcome->getHTML(), "left", "340px");
$layout->add("logo", $boxLogo->getHTML(), "left", "260px");
$layout->add("graph", $multipleLine->getHTML(), "left", "600px");
?>
<?php Element::header("Bem-vindo"); ?>
<div id="acoes">
	<?php $botoes->writeHTML(); ?>
</div>
<div id="dados">
	<?php
	$layout->writeHTML();
	?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("#btn1, #btn2, #btn3, #btn4, #btn5, #btn6").click(function() {
		Dialog.alert("Botão clicado", "Exemplo");
	});
});
</script>