<!DOCTYPE HTML>
<!--
	Editorial by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>CENCOSUD - Bonus App</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
	
		<?php
			echo link_tag('/css/assets/css/main.css');
		 ?>
		
</head>
	<body class="is-preload">
		<!-- Wrapper -->
			<div id="wrapper">
				<!-- Main -->
					<div id="main">
						<div class="inner">
							<!-- Header -->
								<header id="header">
									<a href="mobile" class="logo"><strong>CENCOSUD</strong> Revisión Salarial</a>
								</header>

							<!-- Banner -->
								<section id="banner">
									<div class="content">
										<header>
											<h1>Revisión Salarial<br />
											</h1>
											<p>POC - Interservices 2018</p>
										</header>
									</div>
									<span class="image object">
										<img style="background: #0c5cd4 url(images/logo_cenco_transparente.png) center center no-repeat;" />
									</span>
								</section>
						</div>
						<div>
							<table>
								<thead>
									<th>Empleado</th>
									<th>Accion</th>
								</thead>
								<tbody>
									<?php
										foreach ($nomina as $nomina_item):
										echo form_open('Mobile/aprobarSalario');
									?>
										<tr>
										<td><input type="text" size="2" id="txtLegajo" name="txtLegajo" value="<?=$nomina_item['legajo']?>" /></td>				
										<td><?=$nomina_item['nombre_completo']?></td>
										</tr>
										<tr></tr>
										<td><input type="text" size="2" id="txtSalarioPropuesto_<?=$nomina_item['legajo']?>" name="txtSalarioPropuesto_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_salario_propuesto']?>" /></td>				
										<td><input type="submit" name="aprobar" id="aprobar" value="Aprobar"/></td>	
										</tr>
										</form>
									<?php
										endforeach;
									?>
								</tbody>
							</table>
						</div>
					</div>

				<!-- Sidebar -->
					<div id="sidebar">
						<div class="inner">
							<!-- Menu -->
								<nav id="menu">
									<header class="major">
										<h2>Menu</h2>
									</header>
									<ul>
										<li><a href="mobile">Gestion Salarial</a></li>
										<li><a href="mobile">Alertas</a></li>
									</ul>
								</nav>

							<!-- Footer -->
								<footer id="footer">
									<p class="copyright">POC - Interservices 2018</a>.</p>
								</footer>
						</div>
					</div>
			</div>

		<!-- Scripts -->
		<script type="text/javascript" src="<?php echo base_url();?>css/assets/js/jquery.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>css/assets/js/browser.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>css/assets/js/breakpoints.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>css/assets/js/util.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>css/assets/js/main.js"></script>

	</body>
</html>
