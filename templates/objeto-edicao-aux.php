<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUserInPopup("feedback_consultar");

// Captura das chaves PK e FK //////////////////////////////////////////////////////////////////////////////////////////
$fk_id = Param::getInt("fk_id");
$id = Param::getInt("id");

// Tratamento de campos ////////////////////////////////////////////////////////////////////////////////////////////////
if ($id > 0) {
	$sql = "SELECT * FROM historico WHERE historico_id=" . $id;
	$row = DBH::getRow($sql);
	if (sizeof($row) > 0) {
		$bd_historico_id = $row["historico_id"];
		$bd_usuario_id = $row["usuario_id"];
		$bd_data_cadastro = Dates::format($row["data_cadastro"]);
		$bd_descricao = $row["descricao"];
	}
} else {
	$bd_data_cadastro = date("d/m/Y");
}


// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnSalvar", "Salvar");
$button->add("btnFechar", "Fechar");

// Formulário ///////////////////////////////////////////////////////////////////////////////////////////////////////////
$form = new Form("frm", "../templates/objeto-controller.php", "post");
$form->addHidden("f_id", $id);
$form->addHidden("f_fk_id", $fk_id);

$form->addField("Data de cadastro", Field::text("f_data_cadastro", $bd_data_cadastro,11,10));
$form->addField("Descrição", Field::textarea("f_descricao", $bd_descricao, 5, 50, 200));

// Título da página /////////////////////////////////////////////////////////////////////////////////////////////////////
$pageTitle = "Edição de Objeto Auxiliar";
if ($id==0) $pageTitle = "Novo Objeto Auxiliar";
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
						$.post("../templates/objeto-controller.php?action=salvar1n", $("#frm").serialize(), salvar1nCallback, "json");
					}
				});

				// ação do botão Fechar
				$("#btnFechar").click(function() {
					iframePopup.close();
				});

				// adiciona máscaras nos campos
				$("#f_data_cadastro").mask("99/99/9999");

				// adiciona datepicker nos campos data
				$("#f_data_cadastro").datepicker();

				// foco no campo
				$("#f_descricao").focus();

				// prepara validações de campos
				$("#frm").validate({
					rules: {
						f_descricao: { required: true },
						f_data_cadastro: { required: true, brazilianDate: true }
					},
					messages: {
						f_descricao: { required: "Descrição deve ser informada" },
						f_data_cadastro: { required: "Informe uma data válida" }
					}
				});

			});

			// callback do botão Salvar
			function salvar1nCallback(data) {
				if (data.ok == "1") {
					iframePopup.reload();
				} else {
					Messages.error(data.erro);
				}
			}

		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::headerLov($pageTitle); ?>
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