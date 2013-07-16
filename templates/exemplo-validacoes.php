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
$form->addField("Usuário", Field::text("f_nome_usuario", "", 30, 30), "Validação: Usuário duplicado e campo obrigatório");
$form->addField("E-mail", Field::text("f_email", "", 50, 50), "Validação: E-mail válido e campo obrigatório");
$form->addField("Data", Field::text("f_data", "", 10, 11), "Validação: Data válida e campo obrigatório");
$form->addField("Valor", Field::text("f_valor", "", 10, 11), "Validação: Intervalo entre 15 e 95 e campo obrigatório");
$form->addField("Número", Field::text("f_numero", "", 10, 11), "Validação: Número válido");
$form->addField("Dígitos", Field::text("f_digito", "", 10, 11), "Validação: Dígitos válidos");
$form->addField("Palavra", Field::text("f_palavra", "", 50, 50), "Validação: Palavra com tamanho entre 3 e 30 caracteres, e campo obrigatório caso o valor do campo [dígito] seja maior que 3");
$form->addField("CPF", Field::text("f_cpf", "", 14, 14), "Validação: CPF válido");
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
					if ($("#frm").valid()) {
						Messages.success("Dados enviados com sucesso!");
					}
				});
				
			
				// prepara validações de campos
				$("#frm").validate({
					rules: {
						f_nome_usuario: {
							minlength: 2,
							required: true,
							remote: "../templates/objeto-controller.php?action=validanomeusuario&f_id=0",
							nowhitespace: true,
							lettersonly: true
						},
						f_email: { required: true, email: true },
						f_data: { required: true, brazilianDate: true },
						f_valor: { required: true, range: [15, 95]},
						f_numero: { number: true },
						f_digito: { digits: true },
						f_palavra: {
							rangelength: [3,30],
							required: function() { return $("#f_digito").val() > 3; }},
						f_cpf: { CPF: true }
					},
					messages: {
						f_nome_usuario: {
							required: "Nome de usuário deve ser informado",
							remote: "Nome de usuário já existente",
							nowhitespace: "Nome de usuário não pode conter espaços em branco",
							lettersonly: "Informe somente letras"
						},
						f_email: { required: "E-mail deve ser informado" },
						f_data: { required: "Informe uma data válida" },
						f_valor: { required: "Valor deve ser informado" },
						f_numero: { number: "Informe um número válido" },
						f_digito: { digits: "Informe dígitos válidos" },
						f_palavra: { rangelength: "Informe palavra com tamanho entre 3 e 30 caracteres"}
					}
				});
				
			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo de validações"); ?>
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