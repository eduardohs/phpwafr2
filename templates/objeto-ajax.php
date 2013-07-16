<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnBotao", "Botão");

// Formulário - carga simples ///////////////////////////////////////////////////////////////////////////////////////////
$form1 = new Form("frm1");
$form1->addBreak("Exemplo 1 - Carga simples do servidor");
$form1->addField("Insira um nome", Field::text("f_nome", "", 50, 50));
$form1->addField("Mensagem gerada em ajax", Element::placeHolder("msgGerada"));

// Formulário - Carga de dados do banco /////////////////////////////////////////////////////////////////////////////////
$form2 = new Form("frm2");
$form2->addBreak("Exemplo 2 - Acessando banco de dados");
$form2->addField("Lista de departamentos", Element::placeHolder("listaDepartamentos") . Button::quickButton("btnEx2", "Carregar departamentos"));

// Formlário - Inclusão de dados ////////////////////////////////////////////////////////////////////////////////////////
$form3 = new Form("frm3");
$form3->addBreak("Exemplo 3 - Novo Departamento");
$form3->addField("Nome do departamento", Field::text("f_nome_departamento", "", 50, 50) . Button::quickButton("btnEx3", "Incluir"));
$form3->addField("", Element::placeHolder("respostaInclusao"));

// Formulário - Listbox encadeado ///////////////////////////////////////////////////////////////////////////////////////
$form4 = new Form("frm4");

$lista1 = array(
	array("id"=>1,"label"=>"Item 1"),
	array("id"=>2,"label"=>"Item 2"),
	array("id"=>3,"label"=>"Item 3"),
	array("id"=>4,"label"=>"Item 4"),
	array("id"=>5,"label"=>"Item 5")
);
$lista2 = array();
$lista3 = array();

$form4->addBreak("Exemplo 4 - Listbox encadeado");
$form4->addField("Lista 1", Field::select("lst1", $lista1, "0", "- Selecione -"));
$form4->addField("Lista 2", Field::select("lst2", $lista2, "0"));
$form4->addField("Lista 3", Field::select("lst3", $lista3, "0"));

// Formulário - Autocomplete ////////////////////////////////////////////////////////////////////////////////////////////
$form5 = new Form("frm5");
$form5->addBreak("Exemplo 5 - AutoComplete");
$form5->addField("Nome do usuário", Field::text("ac_nome_usuario", "", 50, 50));
$form5->addField("ID do usuário", Field::text("ac_id_usuario", "", 10, 10));

// Abas
$aba = new MemoryTabs();
$aba->add("Exemplo 1",$form1->getHTML());
$aba->add("Exemplo 2",$form2->getHTML());
$aba->add("Exemplo 3",$form3->getHTML());
$aba->add("Exemplo 4",$form4->getHTML());
$aba->add("Exemplo 5",$form5->getHTML());
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				
				// ação ao pressionar uma tecla dentro do campo f_nome
				$("#f_nome").keyup(function() {
					$.ajax({
						url: "../templates/objeto-controller.php?action=ex1",
						data: $("#frm1").serialize(),
						dataType: "json",
						success: function(data) {
							$("#msgGerada").html(data.valor);
						}
					});
				});
				
				// ação do botão Carregar Departamentos
				$("#btnEx2").click(function() {
					$("#listaDepartamentos").load("../templates/objeto-controller.php?action=ex2");
				});
				
				// ação do botão Incluir
				$("#btnEx3").click(function() {
					$.post("../templates/objeto-controller.php?action=ex3",
					$("#frm3").serialize(),
					function(data) {
						if (data.ok == "1") {
							$("#respostaInclusao").html(data.valor);
							$("#btnEx2").click();
						} else {
							Messages.error(data.erro);
						}
					},
					"json");
				});
				
				// ação ao alterar o primeiro campo SELECT
				$("#lst1").change(function() {
					$.post("../templates/objeto-controller.php?action=ex4",
					{ "chave": $("#lst1").val() },
					function(data){
						$("#lst2").html(data.valor);
						$("#lst3").html("");
					},
					"json");
				});

				// ação ao alterar o segundo campo SELECT
				$("#lst2").change(function() {
					$.post("../templates/objeto-controller.php?action=ex5",
					{ "chave": $("#lst2").val() },
					function(data){
						$("#lst3").html(data.valor);
					},
					"json");
				});
				
				// ação ao alterar o terceiro campo SELECT
				$("#lst3").change(function() {
					Messages.success("Valor selecionado:" + $("#lst3").val());
				});
				
				
				// adiciona autocomplete ao campo ac_nome_usuario
				$("#ac_nome_usuario").autocomplete({
					source: "../templates/objeto-controller.php?action=ex6",
					minLength: 1,
					select: function(event, ui) {
						$(this).val(ui.item.label);
						$("#ac_id_usuario").val(ui.item.id);
					},
					change: function( event, ui ) {
						if (!ui.item) {
							$(this).val("");
							$("#ac_id_usuario").val("");
							return false;
						}
					}
		
				});
			});			
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo AJAX"); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$aba->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>