<?php
include_once("../inc/common.php");

// Controle de acesso //////////////////////////////////////////////////////////////////////////////////////////////////
Security::verifyUser("feedback_consultar");

$cal = new Calendar(date("m"), date("Y"));
$cal->addEvento("01","08:00","Reunião com o cliente");
$cal->addEvento("03","09:00","Levar o Bob pra passear");
$cal->addEvento("03","11:00","Comprar cerveja Coruja");
$cal->addEvento("03","12:00","Churrasco com a galera");
$cal->addEvento("03","16:00","Correr no parque Marinha");
$cal->addEvento("05","12:00","Almoço com Chuck Norris");
$cal->addEvento("05","15:00","Jogar paddle com Tim Cook");
$cal->addEvento("13","08:00","Comprar Kit Kat");
$cal->addEvento("13","","Lavar o carro");
$cal->addEvento("08","09:00","Correr no parque");
$cal->addEvento("08","20:00","Ir ao cinema");
$cal->addEvento("18","09:15","Iniciar projeto usando o phpWafr");
$cal->addEvento("28","15:00","Entregar sistema feito no phpWafr");
$cal->addEvento("09","","Dia de folga","javascript:Dialog.alert(\"Aqui você pode colocar um link para direcionar este evento para outra página\")");
$cal->addEvento("28","","Tomar chimarrão no Parcão");
$cal->addEvento("24","09:00","Apresentar palestra sobre phpWAFr na PUCRS");

// Mês e Ano
$mes_ano = Format::date(date("F"),"F")."/".date("Y");

// Botões ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
$button = new Button();
$button->add("btnBotao", "Botão");
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript">
			$(document).ready(function(){
				
				// ação do botão de exemplo
				$("#btnBotao").click(function() {
					Messages.success("Botão clicado com sucesso!");
				});

			});			
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Página de Calendário - ".$mes_ano); ?>
			<div id="acoes"><?php $button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				Messages::handleMessages();
				$cal->writeHTML();
				?>
			</div>
		</div>

    </body>
</html>