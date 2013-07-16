<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Inclusão ////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (Param::get("op") == "i") {
	$error = new Error();
	$msg = "Registro incluído com sucesso.";
	if (Param::get("f_nome_sistema") == "")
		$error->add('Nome do sistema deve ser informado.');
	if (!$error->hasError()) { // passou na validação
		$rows = array (
			"nome_sistema" => Param::get("f_nome_sistema")
		);
		$db = new DBH();
		if (Param::getInt("f_id") > 0) {
			$msg = "Registro atualizado com sucesso.";
			$db->update("sistema", $rows, "sistema_id=".Param::getInt("f_id"));
		} else {
			$db->insert("sistema", $rows);
		}
		$db = null;
		Messages::sendSuccess($msg);
	} else { // não passou na validação
		Messages::sendError($error->toString());
	}
}



// Exclusão ////////////////////////////////////////////////////////////////////////////////////////////////////////////
if (Param::get("op") == "e") {
	$list_exclusao = implode(",", Param::getArray("sel"));

	$error = new Error();
	$sqlQtde = "SELECT count(*) as qtde FROM sistema_usuario WHERE sistema_id IN (" . $list_exclusao . ")";
	if (DBH::getColumn($sqlQtde) > 0)
		$error->add('Existem registros associados em Sistemas do Usuário.');

	if ($error->hasError()) { // se não passou na validação...
		Messages::sendError($error->toString());
	} else { // se passou na validação...
		if (strlen($list_exclusao) == 0) { // se não existe registros selecionados
			Messages::sendError("Nenhum registro selecionado");
		} else { // se existe registro selecionado
			$db = new DBH();
			$db->delete("sistema", "sistema_id IN ($list_exclusao)");
			$db = null;
			Messages::sendSuccess("Registro excluído com sucesso.");
		}
	}
}


// Expressão SQL e criação do array de registros /////////////////////////////////////////////////////////////////////////
$sql = "SELECT * FROM sistema ORDER BY nome_sistema";
$rows = DBH::getRows($sql);

// Deck de botões ////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnIncluir", "Incluir");
$button->add("btnLimpar", "Limpar");
$button->add("btnExcluir", "Excluir");

// Lista de dados ////////////////////////////////////////////////////////////////////////////////////////////////////////
$table = new Table("lista", 2);
$table->addHidden("op", "");
$table->addCheckboxColumnHeader();
$table->addColumnHeader("Nome do sistema", false, "100%");

$table->addData("&nbsp;");
$table->addHidden("f_id", "");
$table->addData(Field::text("f_nome_sistema", "", 50, 50));

foreach ($rows as $row) {
	$id = $row["sistema_id"];
	$valor = $row["nome_sistema"];

	$table->addCheckboxData($id);
	$table->addData(Element::link($valor, "javascript:preparaEdicao(\"$id\", \"" . $valor . "\")"));
}
?>
<!DOCTYPE html>
<html>
	<head>
		<?php Element::headBlock(); ?>
		<script type="text/javascript">
			$(document).ready(function(){

				// ação do botão Incluir
				$("#btnIncluir").click(function() {
					$("#lista").attr("action","<?php echo $_SERVER['PHP_SELF']; ?>");
					$("#op").val("i");
					$("#lista").submit();
				});

				// ação do botão Excluir
				$("#btnExcluir").click(function() {
					$("#lista").attr("action","<?php echo $_SERVER['PHP_SELF']; ?>");
					$("#op").val("e");
					$("#lista").submit();
				});

				// ação do botão Limpar
				$("#btnLimpar").click(function() {
					$("#f_id").val("");
					$("#f_nome_sistema").val("");
					$("#btnIncluir").val("Incluir");
					$("#f_nome_sistema").focus();
				});

				//@todo automatizar captura da tecla
				$("#lista").keypress(function(e){
					if (e.which == 13) {
						$("#btnIncluir").click();
					}
					preventDefault();
					return false;
				});

				// foco no campo
				$("#f_nome_sistema").focus();

				// hightlight ao passar o mouse
				Tables.setHighlightOnHover(true);

			});


			// alimenta os campos para edição do registro existente
			function preparaEdicao(id, valor) {
				$("#f_id").val(id);
				$("#f_nome_sistema").val(valor);
				$("#btnIncluir").val("Salvar");
				$("#f_nome_sistema").focus();

			}
		</script>
	</head>
	<body>
		<div id="container">
			<?php Element::header("MiniCRUD"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$table->writeHTML();
				Paging::writeQtdeReg(sizeof($rows));
				?>
			</div>
		</div>
	</body>
</html>