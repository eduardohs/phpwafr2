<?php
session_start();
if (!isset($_SESSION["sis_username"]))
	return "";
?>
<ul class="sf-menu">
	<li class="current">
		<a href="../common/index.php">Dashboard</a>
	</li>

	<li>
		<a href="#">Templates</a>
		<ul>
			<li><a href="../templates/objeto-pesquisa.php">Objeto Pesquisa</a></li>
			<li><a href="../templates/objeto-lista.php?clear=1">Objeto Lista</a></li>
			<li><a href="../templates/objeto-listapesquisa.php?clear=1">Objeto Pesquisa Lista</a></li>
			<li><a href="../templates/objeto-listaencadeada.php?clear=1">Objeto Lista Encadeada</a></li>
			<li><a href="../templates/objeto-edicao.php">Objeto Edição</a></li>
			<li><a href="../templates/objeto-minicrud.php">Objeto MiniCRUD</a></li>
			<li><a href="../templates/objeto-geral.php">Objeto Geral</a></li>
			<li><a href="../templates/objeto-grid.php?clear=1">Objeto Grid</a></li>
			<li><a href="../templates/objeto-calendario.php">Objeto Calendário</a></li>
			<li><a href="../templates/objeto-ajax.php">Objeto Ajax</a></li>
			<li><a href="../templates/objeto-webservice.php">Objeto WebService</a></li>
			<li><a href="../templates/objeto-chart.php">Objeto Chart</a></li>
		</ul>
	</li>

	<li>
		<a href="#">Exemplos</a>
		<ul>
			<li><a href="../templates/exemplo-campos.php">Campos especiais</a></li>
			<li><a href="../templates/exemplo-mascaras.php">Máscaras em campos</a></li>
			<li><a href="../templates/exemplo-validacoes.php">Validações em campos</a></li>
			<li><a href="../templates/exemplo-containers.php">Containers</a></li>
			<li><a href="../templates/exemplo-mapa.php">Mapa</a></li>
		</ul>
	</li>


	<li>
		<a href="#">Menu Dois</a>
		<ul>
			<li>
				<a href="#">menu item</a>
				<ul>
					<li><a href="#">short</a></li>
					<li><a href="#">short</a></li>
					<li><a href="#">short</a></li>
					<li><a href="#">short</a></li>
					<li><a href="#">short</a></li>
				</ul>
			</li>
			<li>
				<a href="#">menu item</a>
				<ul>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
				</ul>
			</li>
			<li>
				<a href="#">menu item</a>
				<ul>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
				</ul>
			</li>
			<li>
				<a href="#">menu item</a>
				<ul>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
				</ul>
			</li>
			<li>
				<a href="#">menu item</a>
				<ul>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
					<li><a href="#">menu item</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li>
		<a href="#">Perfil</a>
		<ul>
			<li>
				<a href="#">Trocar senha</a>
			</li>
		</ul>
	</li>

</ul>