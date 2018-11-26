<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	$host="localhost";
	if ($session_logged_in == TRUE) {
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>CENCOSUD - Revisión Salarial</title>
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
	<!-- Datepicker -->
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-1.12.4.js"></script> -->
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  	<script>
  	$( function() {
	    $( "#periodInicio" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
  	} );
  	</script>
  	<script>
  	$( function() {
	    $( "#periodFin" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
  	} );
  	</script>
	<script>
  	$( function() {
	    $( "#fechaEfectiva" ).datepicker({
			dateFormat: "yy-mm-dd"
		});
  	} );
  	</script>
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto+Slab">

	<?php
		echo link_tag('css/helper.css');
		echo link_tag('css/dropdown/themes/flickrcom/default.ultimate.css');
		echo link_tag('css/dropdown/dropdown.linear.columnar.css');
		echo link_tag('css/js.css');
	?>

	<!-- Milligram -->
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
	<link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
	<?php
		echo link_tag('css/milligram.css');
	?>

	<!--	<link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css"> -->

</head>

<!-- <body class="flickr-com"> -->
<body>
<div id="contenedor">
	<div id="cabecera">
		<!-- <p><a href="http://www.lwis.net/free-css-drop-down-menu/" class="main-site">Main site</a></p> -->
		<!--<h1>CENCOSUD - Bonus App</h1> -->
		<!-- Beginning of compulsory code below -->
		<div id="cabeceraLogo">
		</div>
	</div>
	<div id="appUserData">
		<p>
			<?php echo('Usuario: '.
					$this->session->userdata('session_name').' ('.
					$this->session->userdata('session_rol').') País: '.
					$this->session->userdata('session_pais').'  '
				);
	  		?>
		</p>	
	</div>

		<div id="navbar">	
		<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/Main'">Inicio</button>
			<?php
					if ($this->session->userdata('session_rol')=='ADMIN'){
			?>	
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/ImportData'">Importar Datos</button>
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/SalaryManagementAdmin'">Revisión Salarial</button>
		<!--	<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/enablecountry'">Países</button> -->
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/ManagePeriod'">Períodos</button>
		<!--	<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/appnotification'">Notificaciones</button> -->
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/AppParameter'">Parámetros</button>
			<?php
					}
					if ($this->session->userdata('session_rol')=='JEFE'){
			?>
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/SalaryManagementAdminJefe'">Revisión Salarial</button>
						
			<?php
					}
					if ($this->session->userdata('session_rol')=='SUPERVISOR'){
			?>
				<button class="button button-clear" onclick="openCity(event, 'gestionSalarialSupervisor')">Revisión Salarial</button>
		
			<?php
					}
					if ($this->session->userdata('session_rol')=='COMPENSACIONES'){
			?>
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/SalaryManagementAdminCompensa'">Revisión Salarial</button>
			<?php
					}
					if ($this->session->userdata('session_rol')=='DIRECTOR'){
			?>
				<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/SalaryManagementAdminDirector'">Revisión Salarial</button>
					
			<?php
					}
			?>		  
			<button class="button button-clear" onclick="window.location.href='http://localhost/cencosud/Main/Logout'">Salir</button>
		</div>

	<?php
	}
	?>	
	<div id="divCuerpo">



