<?php
include_once("../inc/common.php");
if (AUTH_SOE) {
	Http::redirect("../soe/soe-login.php");
}
$ret_page = Param::get("ret_page");
$querystring = Param::get("querystring");

$isContinua = false;
if (!$ret_page) {
	$label_button = "Entrar";
} else {
	$label_button = "Continuar";
	$isContinua = true;
}

// verifica necessidade de exibir captcha
$useCaptcha = false;
if (intval($_SESSION["sis_captcha_tentativas"])>3) {
	$useCaptcha = true;
}

// Botões
$button = new Button();
if ($isContinua) {
	$button->add("btnRetornar", "Retornar");
}
$button->add("btnEntrar", $label_button);

// Formulário de login
$form = new Form("frmLogin", "../common/login-validar.php", "post", false);
$form->addHidden("ret_page", $ret_page);
$form->addHidden("querystring", $querystring);

$form->addField("Usuário", Field::text("f_username", Session::get("sis_username_old"), 20, 50));
$form->addField("Senha", Field::password("f_password", "", 20, 50));
if ($useCaptcha) {
	$form->addField("Código de verificação:","<img src='../inc/captcha/captcha.php?l=150&a=50&tf=28&ql=4' /><br/><br/>".Field::text("f_captcha", "", 10, 4));
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
				
				$("#f_username").focus();
				
				Buttons.mapEnterKey("btnEntrar");
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Login"); ?>
			<div id="acoes"><?php //$button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				echo "<div style='width: 300px; margin-left: auto; margin-right: auto; margin-top: 100px;'>";
				$form->writeHTML();
				echo "</div>";
				echo "<div id='logo-login' /></div>";
				?>
			</div>
		</div>

    </body>
</html>