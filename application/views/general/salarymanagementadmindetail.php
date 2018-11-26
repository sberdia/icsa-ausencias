<script>
	function calcularSalario(){
		var salarioActual;
		var ajusteSalario;
		var nuevoSalario;
		salarioActual =document.getElementById("txtSalarioActual").value;
		ajusteSalario =document.getElementById("txtAjusteSalario").value;
		nuevoSalario = salarioActual + ((salarioActual * ajusteSalario)/100);
		document.getElementById("txtNuevoSalario").value = nuevoSalario;
		return false;
	}
</script>

<!-- Tab links -->
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'datosPersonales')">Datos Personales</button>
  <button class="tablinks" onclick="openCity(event, 'compensacion')">Compensación</button>
	<button class="tablinks" onclick="openCity(event, 'nuevoSalario')">Nuevo Salario</button>
	<button class="tablinks" onclick="openCity(event, 'nuevaCompensacion')">Nueva Compensación</button>
	<button class="tablinks" onclick="openCity(event, 'alertas')">Alertas</button>
	<button class="tablinks" onclick="openCity(event, 'comentarios')">Comentarios</button>
</div>

<?php 
foreach ($nomina as $nomina_item):
?>

<!-- DATOS PERSONALES -->
<div id="datosPersonales" class="tabcontent" id="datosPersonales">
  <h3>Datos Personales</h3>
	<p>Los datos personales del empleado.</p>
	Legajo: <?php echo $nomina_item['legajo']; ?> <br>
	Nombre: <?php echo $nomina_item['nombre']; ?> <br>
	Apellido Paterno: <?php echo $nomina_item['apellido_paterno']; ?> <br>
	Apellido Materno: <?php echo $nomina_item['apellido_materno']; ?> <br>
	Email: <?php echo $nomina_item['email']; ?> <br>
	Género: <?php echo $nomina_item['genero']; ?> <br>
	País: <?php echo $nomina_item['pais']; ?> <br>
	Ciudad: <?php echo $nomina_item['ciudad']; ?> <br>
	Fecha Nacimiento: <?php echo $nomina_item['fecha_nacimiento']; ?> <br>
</div>

<!-- COMPENSACION -->
<div id="compensacion" class="tabcontent">
  <h3>Compensación</h3>
	<p>Los datos de compensación del empleado.</p>
	División: <?php echo $nomina_item['division']; ?> <br>
	Cargo: <?php echo $nomina_item['cargo']; ?> <br>
	Moneda: <?php echo $nomina_item['moneda']; ?> <br>
	Bono: <?php echo '????????????'; ?> <br>
	Salario Mensual: <?php echo '????????????'; ?> <br>
	Salario Anual: <?php echo '????????????'; ?> <br>
	Salario Mensual USD: <?php echo '????????????'; ?> <br>
	Eval. Desempeño: <?php echo '????????????'; ?> <br>
	Pos de Rango: <?php echo '????????????'; ?> <br>
	Prioridad Ajuste: <?php echo '????????????'; ?> <br>
	Compa-Ratio: <?php echo '????????????'; ?> <br>
	Pauta (%): <?php echo '????????????'; ?> <br>
</div>

<!-- NUEVO SALARIO -->
<div id="nuevoSalario" class="tabcontent">
  <h3>Nuevo Salario</h3>
	<p>Los datos del nuevo salario del empleado.</p>
	Salario Mensual: <input type="text" id="txtSalarioActual" value= "<?php echo $nomina_item['salario_enero'];?>"><br>
	Ajuste salario (%): <input type="text" id="txtAjusteSalario"/> <button onclick="calcularSalario();">Calcular</button><br>
	Ajuste salario (Importe): <input type="text" id="txtNuevoSalario"/> <br>
</div>

<div id="nuevaCompensacion" class="tabcontent">
  <h3>Nueva Compensación</h3>
	<p>Los datos de la nueva compensación del empleado.</p>
	Bonos - Rango:  <?php echo '????????????'; ?> <br>
	Salario Anual: <?php echo '????????????'; ?> <br>
	Salario Anual USD: <?php echo '????????????'; ?> <br>
	Compra-Ratio: <?php echo '????????????'; ?> <br>
	Compra-Ratio Dif: <?php echo '????????????'; ?> <br>
</div>

<div id="alertas" class="tabcontent">
  <h3>Alertas</h3>
  <p>Las alertas del empleado.</p>
</div>

<div id="comentarios" class="tabcontent">
  <h3>Nuevo Salario</h3>
  <p>Los comentarios del empleado.</p>
</div>

	<?php 
	endforeach;
	?>


<?php
/*
$this->table->set_heading(array('Nombre completo', 'Email', 'País', 'Base'));

foreach ($nomina as $nomina_item):
	
	$this->table->add_row(array(
			$nomina_item['nombre_completo'], 
			$nomina_item['email'],
			$nomina_item['pais'],
			$nomina_item['base_importe_calculo_bono']
		));

	// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
endforeach;

echo $this->table->generate();
*/
?>
