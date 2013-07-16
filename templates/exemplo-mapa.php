<?php
include_once("../inc/common.php");

// Controle de acesso
Security::verifyUser("feedback_consultar");

// Botões
//$button = new Button();
//$button->add("btnPesquisar", "Pesquisar");

// Formulário de pesquisa
$form = new Form("frm");
$form->setAutoNewLine(false);
$form->addField("Endereço", Field::text("f_end", "", 60));
$form->addField(Button::quickButton("btnPesquisar", "Ok"));
$form->newLine();
?>
<!DOCTYPE html>
<html>
    <head>
		<?php
		Element::headBlock();
		?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
		<script type="text/javascript" src="../inc/js/gmaps.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){

				// inicializa google maps
				map = new GMaps({
					div: '#mapa',
					zoom: 15,
					lat: -30,
					lng: -51
				});

				// localização inicial
				GMaps.geocode({
					address: 'porto alegre, brazil',
					callback: function(results, status){
						if(status=='OK'){
							var latlng = results[0].geometry.location;
							map.setCenter(latlng.lat(), latlng.lng());
						}
					}
				});

				// localização a partir do botão pesquisar
				$('#btnPesquisar').click(function() {
					GMaps.geocode({
						address: $('#f_end').val().trim(),
						callback: function(results, status){
							if(status=='OK'){
								var latlng = results[0].geometry.location;
								map.setCenter(latlng.lat(), latlng.lng());
								map.addMarker({
									lat: latlng.lat(),
									lng: latlng.lng(),
									title: $('#f_end').val().trim(),
									infoWindow: {
										content: '<p>'+$('#f_end').val() + '</p>'
									}
								});
							}
						}
					});
				});

				// estilo da caixa de mapa
				$("#mapa").css({ 'margin':'5px','width': 'auto', 'height': '500px', 'border': '3px solid #999999' });

				Buttons.mapEnterKey("btnPesquisar");

				$("#f_end").focus();

			});
		</script>
    </head>
    <body>
		<div id="container">
			<?php Element::header("Exemplo de mapa"); ?>
			<div id="acoes"><?php //$button->writeHTML(); ?></div>
			<div id="dados">
				<?php
				$form->writeHTML();
				Messages::handleMessages();
				Element::div("mapa");
				?>
			</div>
		</div>
    </body>
</html>