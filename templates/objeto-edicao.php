<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Tratamento de campos ////////////////////////////////////////////////////////////////////////////////////////////////
$id = Param::getInt("id"); // captura a chave
if ($id > 0) { // edição
	$sql = "SELECT * FROM usuario WHERE usuario_id=" . $id;
	$row = DBH::getRow($sql);
	if (sizeof($row) > 0) {
		$bd_usuario_id = $row["usuario_id"];
		$bd_data_cadastro = Dates::format($row["data_cadastro"]);
		$bd_nome_usuario = $row["nome_usuario"];
		$bd_senha = $row["senha"];
		$bd_nivel_acesso = $row["nivel_acesso"];
		$bd_nome_real = $row["nome_real"];
		$bd_departamento_id = $row["departamento_id"];
		$bd_email = $row["email"];
		$bd_descricao = $row["descricao"];
		$bd_ativo = $row["ativo"];

		$bd_sistemas = DBH::getRows("SELECT sistema.sistema_id as id, sistema.nome_sistema as label FROM sistema, sistema_usuario WHERE sistema.sistema_id=sistema_usuario.sistema_id AND sistema_usuario.usuario_id=".$bd_usuario_id);
		$sistemasUsuario = DBH::getRows("SELECT sistema_id as id FROM sistema_usuario WHERE usuario_id=".$id);
	}
} else { // inclusão
	$bd_data_cadastro = date("d/m/Y");
	$bd_nivel_acesso = 1;
}

// Prepara lista de dados ///////////////////////////////////////////////////////////////////////////////////////////////
$rowsDepartamento = DBH::getRows("SELECT departamento_id as id, nome_departamento as label FROM departamento ORDER BY nome_departamento");
$rowsNivel = array(
	array("id"=>1,"label"=>"Operador"),
	array("id"=>2,"label"=>"Manutenção"),
	array("id"=>3,"label"=>"Administrador")
);
$listaSistemas = DBH::getRows("SELECT sistema_id as id, nome_sistema as label FROM sistema ORDER BY nome_sistema");


// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnSalvar", "Salvar");
$button->add("btnFechar", "Fechar");

// Abas /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$tabs = new Tabs();
$tabs->add("Geral", true);
if ($id > 0) { // se for inclusão, esconde as outras abas
	$tabs->add("Associação N:N", false, "../templates/objeto-associacao.php?id=" . $id);
	$tabs->add("Detalhe", false, "../templates/objeto-consulta.php?id=" . $id);
	$tabs->add("Lista 1:N", false, "../templates/objeto-lista-1n.php?id=" . $id, "feedback_consultar");
}

// Formulário
$form = new Form("frm", "../templates/objeto-controller.php?action=salvar", "post");
$form->addHidden("f_id", $bd_usuario_id); // chave primária
$form->addField("* Data de cadastro", Field::text("f_data_cadastro", $bd_data_cadastro, 10, 11));
$form->addField("* Nome do usuário", Field::text("f_nome_usuario", $bd_nome_usuario, 20, 20), "O nome de usuário informado será utilizado para login no sistema");
if ($id == 0) {
	$form->addField("* Senha", Field::password("f_password", $bd_senha, 20, 20));
}
$form->addField("* Nível de acesso", Field::radio("f_nivel_acesso", $rowsNivel, $bd_nivel_acesso, "h"));
$form->addField("* Nome real", Field::text("f_nome_real", $bd_nome_real, 50, 50));
$form->addField("* E-mail", Field::text("f_email", $bd_email, 50, 100));
$form->addField("* Departamento", Field::select("f_departamento_id", $rowsDepartamento, $bd_departamento_id, "", ""));
$form->addField("Descrição", Field::textarea("f_descricao", $bd_descricao, 3, 50, 200, "Insira um texto livre aqui"));
$form->addField("Ativo", Field::checkbox("f_ativo", 1, $bd_ativo == 1));
$form->addBreak("Exemplo de outros campos");
$form->addField("Exemplo de campo Hora", Field::text("f_hora", "", 6));
$form->addField("Exemplo de MultipleCheckbox",Field::multipleCheckbox("f_multiplecheckbox", $listaSistemas, $sistemasUsuario, "h"));
$form->addField("Exemplo de LOV", Field::lov("f_campoTesteLov", $bd_usuario_id, $bd_nome_real, "../templates/objeto-lov.php", 600));
$form->addField("Exemplo de ListboxLov",Field::listboxLov("f_listboxlov", "../templates/objeto-listboxlov.php", $bd_sistemas, 7, "400px"));


$form->setComment("(*) Campos obrigatórios");

// Título da página /////////////////////////////////////////////////////////////////////////////////////////////////////
$pageTitle = "Edição de Objeto";
if ($id==0) $pageTitle = "Novo Objeto";
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
						ListboxLov.selectAll("f_listboxlov");
						$.post("../templates/objeto-controller.php?action=salvar", $("#frm").serialize(), salvarCallback, "json");
					}
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					location = "../templates/objeto-lista.php";
				});

				// adiciona datepicker nos campos data
				$("#f_data_cadastro").datepicker();

				// adiciona timepicker
				$('#f_hora').datetimepicker();

				// adiciona máscara nos campos
				$("#f_data_cadastro").mask("99/99/9999");
				$("#f_hora").mask("99:99");

				// foco no campo
				$("#f_nome_usuario").focus();

				// prepara validações de campos
				$("#frm").validate({
					rules: {
						f_nome_usuario: { minlength: 2, required: true, remote: "../templates/objeto-controller.php?action=validanomeusuario&f_id="+$("#f_id").val() },
						f_nome_real: { required: true, minlength: 2 },
						f_email: { required: true, email: true },
						f_data_cadastro: { required: true, brazilianDate: true },
						f_password: { required: true, minlength: 6 }
					},
					messages: {
						f_nome_usuario: { required: "Nome de usuário deve ser informado", remote: "Nome de usuário já existente" },
						f_nome_real: { required: "Nome real deve ser informado" },
						f_email: { required: "E-mail deve ser informado" },
						f_data_cadastro: { required: "Informe uma data válida" },
						f_password: { required: "Senha deve ser informada", minlength: "Senha deve ter 6 ou mais caracteres"}
					}
				});

				// define qual botão será acionado ao pressionar Enter
				Buttons.mapEnterKey("btnSalvar");
			});


			// callback do botão Salvar
			function salvarCallback(data) {
				if (data.ok == "1") {
					if (data.modo=="a") {
						location = "../templates/objeto-lista.php";
					} else {
						location = "../templates/objeto-edicao.php?id="+data.id;
					}
				} else {
					Messages.error(data.erro);
				}
			}

		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header($pageTitle); ?>
			<div id="acoes"><?php $button->writeHTML(); $tabs->writeHTML();?></div>
			<div id="dados">
				<?php

				Messages::handleMessages();
				$form->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>