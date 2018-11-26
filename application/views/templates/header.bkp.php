<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	if ($session_logged_in == TRUE) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>CENCOSUD - Bonus App</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<script>
		/* Script para Tabs Horizontales*/
		function openCity(evt, cityName) {
		// Declare all variables
		var i, tabcontent, tablinks;

		// Get all elements with class="tabcontent" and hide them
		tabcontent = document.getElementsByClassName("tabcontent");
		for (i = 0; i < tabcontent.length; i++) {
			tabcontent[i].style.display = "none";
		}

		// Get all elements with class="tablinks" and remove the class "active"
		tablinks = document.getElementsByClassName("tablinks");
		for (i = 0; i < tablinks.length; i++) {
			tablinks[i].className = tablinks[i].className.replace(" active", "");
		}

		// Show the current tab, and add an "active" class to the button that opened the tab
		document.getElementById(cityName).style.display = "block";
		evt.currentTarget.className += " active";
	}
	</script>

	<script>
		/* Script para Tabs Verticales */
		function openCityVertical(evt, cityName) {
			// Declare all variables
			var i, tabcontent, tablinks;

			// Get all elements with class="tabcontent" and hide them
			tabcontent = document.getElementsByClassName("tabcontent");
			for (i = 0; i < tabcontent.length; i++) {
				tabcontent[i].style.display = "none";
			}

			// Get all elements with class="tablinks" and remove the class "active"
			tablinks = document.getElementsByClassName("tablinks");
			for (i = 0; i < tablinks.length; i++) {
				tablinks[i].className = tablinks[i].className.replace(" active", "");
			}

			// Show the current tab, and add an "active" class to the link that opened the tab
			document.getElementById(cityName).style.display = "block";
			evt.currentTarget.className += " active";
		}
	</script>
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto+Slab">

	<?php
		echo link_tag('css/helper.css');
		echo link_tag('css/dropdown/themes/flickrcom/default.ultimate.css');
		echo link_tag('css/dropdown/dropdown.linear.columnar.css');
		echo link_tag('css/js.css');
		
		//echo link_tag('css/milligram.css');
	?>

	<!-- Milligram -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
	<link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
	<link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">

</head>

<!-- <body class="flickr-com"> -->
<body>
<div id="contenedor">
	<div id="cabecera">
		<!-- <p><a href="http://www.lwis.net/free-css-drop-down-menu/" class="main-site">Main site</a></p> -->
		<!--<h1>CENCOSUD - Bonus App</h1> -->
		<!--<h1>Bienvenido: <?php /* echo $this->session->userdata('session_name');*/ ?></h1> -->
		<!-- Beginning of compulsory code below -->
	</div>
	<div id="navegador">
	<ul id="nav" class="dropdown dropdown-horizontal">
			<li><a href="./">Inicio</a></li>
			<li><span class="dir">Opciones</span>
				<ul>
				<?php
				if ($this->session->userdata('session_rol')=='ADMIN'){
					echo('<li><a href="http://localhost/cencosud/salarymanagementadmin">Gestion Salarial Admin</a></li>');
					echo('<li><a href="http://localhost/cencosud/importdata">Importar Datos</a></li>');
					echo('<li><a href="http://localhost/cencosud/enablecountry">Habilitación Países</a></li>');
					echo('<li><a href="http://localhost/cencosud/manageperiod">Períodos</a></li>');
					echo('<li><a href="http://localhost/cencosud/salarynotification">Gestión Notificaciones</a></li>');
					echo('<li><a href="http://localhost/cencosud/appconfiguration">Configuracion</a></li>');
				}
				
				if ($this->session->userdata('session_rol')=='JEFE'){
					echo('<li><a href="./">Gestión Salarial Jefe</a></li>');
				}
				
				if ($this->session->userdata('session_rol')=='SUPERVISOR'){
					echo('<li><a href="./">Gestión Salarial Supervisor</a></li>');
				}
						
				if ($this->session->userdata('session_rol')=='COMPENSACIONES'){
					echo('<li><a href="./">Gestión Salarial Compensaciones</a></li>');
				}
				
				if ($this->session->userdata('session_rol')=='DIRECTOR'){
					echo('<li><a href="./">Gestión Salarial Director</a></li>');
				}

				?>
				
				</ul>
			</li>
			<li><a href="main/logout">Logout</a></li>
		</ul>
	</div>
	<div id="divCuerpo">
<?php	
}
?>
