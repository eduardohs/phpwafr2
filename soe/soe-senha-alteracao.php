<?php
include_once("../inc/common.php");

// Botões
$button = new Button();
$button->add("btnAlterar", "Alterar");

// Formulário de login
$form = new Form("frmTrocaSenha", SOE_URL_TROCASENHA, "post");
$form->addHidden("f_origem", Session::get("sis_origem"));
$form->addHidden("f_sistema", SOE_SIGLA_SISTEMA);
$form->addHidden("f_retorno", SOE_URL_FEEDBACK);
$form->addHidden("f_codUsuario", Session::get("sis_cod_usuario"));
$form->addHidden("f_ticket", Session::get("sis_ticket"));

$form->addField("Senha atual", Field::password("f_senha",     "", 8, 8));
$form->addField("Nova Senha",  Field::password("f_senhaNova", "", 8, 8));
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
				
				$("#f_senha").focus();
				
				Buttons.mapEnterKey("btnAlterar");
			});
	
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Alterar Senha SOE"); ?>
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