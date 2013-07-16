<?php
include_once("../inc/common.php");

// verifica necessidade de exibir captcha
$useCaptcha = false;
if (intval($_SESSION["sis_captcha_tentativas"])>3) {
	$useCaptcha = true;
}

// Botões
$button = new Button();
$button->add("btnEntrar", "Entrar");

// Formulário de login
$form = new Form("frmLogin", SOE_URL_AUTENTICACAO, "post", false);
$form->addHidden("f_sistema", SOE_SIGLA_SISTEMA);
$form->addHidden("f_retorno", SOE_URL_FEEDBACK);

$form->addField("Organização", Field::text("f_organizacao", "PROCERGS", 30, 50));
$form->addField("Matrícula", Field::text("f_matricula", "", 30, 20));
$form->addField("Senha", Field::password("f_senha", "", 30, 50));
if ($useCaptcha) {
	$form->addField("Código de verificação","<img src='../inc/captcha/captcha.php?l=150&a=50&tf=28&ql=4' /><br/><br/>".Field::text("f_captcha", "", 10, 4));
}
$form->addField("", "<div style='text-align: right; width: 100%'>".Button::quickButton("btnEntrar", " Login ")."</div>");
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#btnEntrar").click(function() {
					$("#frmLogin").submit(); 
				});
				
				$("#f_matricula").focus();
				
				Buttons.mapEnterKey("btnEntrar");
			});
	
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Login SOE"); ?>
			<div id="acoes"><?php //$button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				echo "<div style='width: 300px; margin-left: auto; margin-right: auto; margin-top: 100px;'>";
				$form->writeHTML();
				echo "</div>";
				?>
			</div>
		</div>

    </body>
</html>