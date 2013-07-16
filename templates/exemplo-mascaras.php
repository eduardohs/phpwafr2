<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnSalvar", "Salvar");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", true);

// Formulário
$form = new Form("frm", "", "post");
$form->addField("Data", Field::text("f_data", "", 10, 11), "Máscara: 99/99/9999");
$form->addField("CPF", Field::text("f_cpf", "", 14, 14), "Máscara: 999.999.999-99");
$form->addField("CNPJ", Field::text("f_cnpj", "", 18, 18), "Máscara: 99.999.999/9999-99");
$form->addField("CEP", Field::text("f_cep", "", 9, 9), "Máscara: 99999-999");
$form->addField("Telefone", Field::text("f_telefone", "", 30, 30), "Máscara: (99) 9999-9999?9");
$form->addField("Placa veículo", Field::text("f_placa", "", 7, 7), "Máscara: aaa-9999");
$form->addField("Valor", Field::text("f_valor", "", 10, 10), "Máscara: ~9?9999<br/>onde [~] corresponde a [+] ou [-]");
$form->addField("Chave de produto", Field::text("f_chave", "", 30, 30), "Máscara: aaa9-****-****");
$form->setComment("a - representa um caracter alfabético (A-Z,a-z)<br/>9 - representa um caracter numérico (0-9)<br/>* - representa um caracter alfanumérico (A-Z,a-z,0-9)");
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				
				// ação do botão Salvar
				$("#btnSalvar").click(function() {
					Messages.success("Dados enviados com sucesso!");
				});
				
			
				// adiciona máscara nos campos
				$("#f_data").mask("99/99/9999", {completed: function() {
						$("#f_cpf").focus();
					}});
				$("#f_cpf").mask("999.999.999-99");
				$("#f_cnpj").mask("99.999.999/9999-99");
				$("#f_cep").mask("99999-999");
				$("#f_telefone").mask("(99) 9999-9999?9");
				$("#f_placa").mask("aaa-9999");
				
				$.mask.definitions['~']='[+-]';
				$("#f_valor").mask("~9?9999");
				
				$("#f_chave").mask("aaa9-****-****", {completed: function() {
						Dialog.alert('Chave '+this.val()+' correta!');
					}});
				
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo de máscaras"); ?>
			<div id="acoes"><?php $button->writeHTML();
			$tabs->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$form->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>