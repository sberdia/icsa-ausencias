
<style>
input[type=text]:disabled {
    background: #dddddd;
}
/* Color para flas de una tabla 
table tr {
	color: #fff;
	background-color: #000;
}
*/
</style>

<script>
	var calcularSalario = function(salario, ajuste, nuevosalario){
		var salarioActual;
		var ajusteSalario;
		var nuevoSal;
		salarioActual = parseInt(document.getElementById(salario).value);
		ajusteSalario = parseInt(document.getElementById(ajuste).value);
		nuevoSal = parseInt(salarioActual + ((salarioActual * ajusteSalario)/100));
		document.getElementById(nuevosalario).value = nuevoSal;
		document.getElementById(nuevosalario).focus;
	}
/*
	$(document).ready(function(){
		$('#divTabLinksSalaryManagement').hide(); // Oculto por default el div del menú hasta que seleccione período.
		$("#btnSeleccionPeriodo").on("click", function() {
			$('#divSeleccionPeriodo').html($('#periodoPais option:selected').html());
			$('#divTabLinksSalaryManagement').show(); //muestro mediante id
		});
	});
*/
</script>


<div id="divSeleccionPeriodo">
<p>Período: <?=$periodoSeleccionado->id_periodo. ' - '.$periodoSeleccionado->pais. ' - '.$periodoSeleccionado->fecha_inicio.' - '.$periodoSeleccionado->fecha_fin;?></p>
</div>

<!-- Tab links -->
<div id="divTabLinksSalaryManagement">
	<button class="button button-outline" onclick="openCity(event, 'datosPersonales')">Datos Personales</button>
	<button class="button button-outline" onclick="openCity(event, 'compensacion')">Compensación</button>
	<button class="button button-outline" onclick="openCity(event, 'nuevoSalario')">Nuevo Salario</button>
	<button class="button button-outline" onclick="openCity(event, 'nuevaCompensacion')">Nueva Compensación</button>
	<button class="button button-outline" onclick="openCity(event, 'alertas')">Alertas</button>
	<button class="button button-outline" onclick="openCity(event, 'comentarios')">Comentarios</button>
</div>

<!-- DATOS PERSONALES -->
<div id="datosPersonales" class="tabcontent" name="datosPersonales">
	<?php
		$this->table->set_heading(array('Nombre Completo', 'Legajo', 'Genero', 'Fecha Nac.', 'Email', 'País', 'Ciudad'));
		foreach ($nomina as $nomina_item):
			$this->table->add_row(
				$nomina_item['nombre_completo'],
				$nomina_item['legajo'],
				$nomina_item['genero'],
				$nomina_item['fecha_nacimiento'],
				$nomina_item['email'],
				$nomina_item['pais'],
				$nomina_item['ciudad']
				);
			// Esto estaba como un item mas para ver el detalle:
			// '<a href='.site_url('salarymanagementadmin/viewDetail/'.$nomina_item['legajo'].'>Ver</a>')
			// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
		endforeach;
		echo $this->table->generate();
	?>
</div>

<!-- COMPENSACION -->
<div id="compensacion" class="tabcontent" name="compensacion">
<table>
		<thead>
			<th>Legajo</th>
			<th>Nombre Completo</th>
			<th>Cargo</th>
			<th>Division</th>
			<th>Moneda</th>
			<th>Bonos</th>
			<th>Salario Mensual</th>
			<th>Salario Anual</th>
			<th>Salario Mensual USD</th>
			<th>Salario Anual USD</th>
			<!--
			<th>Eval. Desempeño</th>
			<th>Pos. de Rango</th>
			<th>Prioridad Ajuste</th>
			<th>Compa-Ratio</th>
			<th>Pauta (%)</th>
			<th>Etapa</th>
			<th>Accion</th>
			-->
		</thead>
		<?php
		foreach ($nomina as $nomina_item):
			echo validation_errors();
			echo form_open('SalaryManagementAdminJefe/proponerCompensacion');
			?>
			<tr>
				<td><input type="text" size="8" id="txtLegajo" name="txtLegajo" value="<?php echo $nomina_item['legajo']?>"/></td>
				<td><?=$nomina_item['nombre_completo']?></td>
				<td><?=$nomina_item['cargo']?></td>
				<td><?=$nomina_item['division']?></td>
				<td><?=$nomina_item['moneda']?></td>
				<td><?=$nomina_item['bonos_totales']?></td>
				<td><?=$nomina_item['salario_enero']?></td>
				<td><?=($nomina_item['salario_enero']*$nomina_item['salarios_anuales'])?></td>
				<td><?=($nomina_item['salario_enero']/$parametros->tipo_cambio)?></td>
				<td><?=(($nomina_item['salario_enero']*$nomina_item['salarios_anuales'])/$parametros->tipo_cambio)?></td>
			</tr>
			
			<tr>
			<!-- Eval. Desempeño -->
				<td><b>Eval. Desemp. </b><br>
					<select id="evaldesempeno_<?=$nomina_item['legajo']?>" name="evaldesempeno_<?=$nomina_item['legajo']?>" disabled>
						<option value="AB" <?php if($nomina_item['comp_eval_desempeno']=="AB") {?> selected <?php } ?>>AB</option>
						<option value="BB" <?php if($nomina_item['comp_eval_desempeno']=="BB") {?> selected <?php } ?>>BB</option>
					</select>
				</td>

			<!-- Pos.del Rango -->
				<td><b>Rango </b><br>
					<select id="posdelrango_<?=$nomina_item['legajo']?>" name="posdelrango_<?=$nomina_item['legajo']?>"  disabled>
						<option value="En Crecimiento" <?php if($nomina_item['comp_pos_de_rango']=="En Crecimiento") {?> selected <?php } ?>>En Crecimiento</option>
						<option value="Mercado" <?php if($nomina_item['comp_pos_de_rango']=="Mercado") {?> selected <?php } ?>>Mercado</option>
					</select>
				</td>
			
			<!-- Prioridad ajuste -->
				<td><b>Prioridad Ajuste</b><br>	
					<select id="prioridaddeajuste_<?=$nomina_item['legajo']?>" name="prioridaddeajuste_<?=$nomina_item['legajo']?>"  disabled>
						<option value="Alta" <?php if($nomina_item['comp_prioridad_ajuste']=="Alta") {?> selected <?php } ?>>Alta</option>
						<option value="Normal" <?php if($nomina_item['comp_prioridad_ajuste']=="Normal") {?> selected <?php } ?>>Normal</option>
						<option value="Sin Incremento" <?php if($nomina_item['comp_prioridad_ajuste']=="Sin Incremento") {?> selected <?php } ?>>Sin Incremento</option>
					</select>
				</td>
			
			<td><b>Comp-Ratio</b><br>TBD</td>

			<!-- Pauta -->
				<td><b>Pauta </b><br>
					<select id="pauta_<?=$nomina_item['legajo']?>" name="pauta_<?=$nomina_item['legajo']?>"  disabled>
						<option value="10" <?php if($nomina_item['comp_pauta']=="10") {?> selected <?php } ?>>10</option>
						<option value="20" <?php if($nomina_item['comp_pauta']=="20") {?> selected <?php } ?>>20</option>
						<option value="30" <?php if($nomina_item['comp_pauta']=="30") {?> selected <?php } ?>>30</option>
					</select>
				</td>	

			<td><br><?=$nomina_item['app_status']?></td>
			<td></td>
			<td></td>
			<td></td>
			
			<?php
				if($nomina_item['app_status']!='VALIDADO'){
			?>
				<td><!-- <input type="submit" value="Guardar"/> --></td> 
			<?php
				}else{
			?>
				<td></td>
			<?php
				}
			?>

			</tr>
			</form>
		<?php
		endforeach;
		?>
	</table>
</div>


<!-- NUEVO SALARIO -->
<div id="nuevoSalario" class="tabcontent" name="nuevoSalario">
	<table>
		<thead>
			<th>Legajo</th>
			<th>Nombre Completo</th>
			<th>Salario</th>
			<th>Ajuste Salario (%)</th>
			<th></th>
			<th>Ajuste Salario (Valor)</th>
			<th>Status</th>
			<th>Acción</th>
		</thead>
		<?php
		foreach ($nomina as $nomina_item):
			echo validation_errors();
			echo form_open('SalaryManagementAdminJefe/proponerPorcentajeSalario');
			?>
			<tr>
				<td><input type="text" size="8" id="txtLegajo" name="txtLegajo" value="<?php echo $nomina_item['legajo']?>"/></td>
				<td><?php echo $nomina_item['nombre_completo'];?></td>				
				<td><input type="text" disabled size="8" id="txtSalario_<?=$nomina_item['legajo']?>" name="txtSalario_<?=$nomina_item['legajo']?>" value="<?php echo $nomina_item['salario_enero']?>"/></td>
				<?php
					if($nomina_item['app_status']=='VALIDADO'){
				?>
						<td><input type="text" disabled size="8" id="txtAjusteSalario_<?=$nomina_item['legajo']?>" name="txtAjusteSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_porcentaje_propuesto']?>"/></td>
						<td></td>
						<td><input type="text" disabled size="8" id="txtNuevoSalario_<?=$nomina_item['legajo']?>" name="txtNuevoSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_salario_propuesto']?>"/></td>		
						<td><?=$nomina_item['app_status']?></td>
						<td>
							<input type="submit" id="aprobar" name="aprobar" value="Aprobar"/>	
							<input type="submit" id="rechazar" name="rechazar" value="Rechazar"/>
						</td>
				<?php
					}
				?>

				<?php
					if($nomina_item['app_status']=='RECHAZADO'){
				?>
						<td><input type="text" disabled size="8" id="txtAjusteSalario_<?=$nomina_item['legajo']?>" name="txtAjusteSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_porcentaje_propuesto']?>"/></td>
						<td>
							<!-- <input type="button" onclick="calcularSalario('txtSalario_<?=$nomina_item['legajo']?>','txtAjusteSalario_<?=$nomina_item['legajo']?>','txtNuevoSalario_<?=$nomina_item['legajo']?>');" value="Calcular"></button> -->
						</td>
						<td><input type="text" disabled size="8" id="txtNuevoSalario_<?=$nomina_item['legajo']?>" name="txtNuevoSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_salario_propuesto']?>"/></td>		
						<td><?=$nomina_item['app_status']?></td>
						<td>
							<!-- <input type="submit" value="Guardar"/> --->
						</td>
				<?php
					}
				?>

				<?php
					if($nomina_item['app_status']=='INICIADO'){
				?>
						<td><input type="text" disabled size="8" id="txtAjusteSalario_<?=$nomina_item['legajo']?>" name="txtAjusteSalario_<?=$nomina_item['legajo']?>"/></td>				
						<td>
							<!-- <input type="button" onclick="calcularSalario('txtSalario_<?=$nomina_item['legajo']?>','txtAjusteSalario_<?=$nomina_item['legajo']?>','txtNuevoSalario_<?=$nomina_item['legajo']?>');" value="Calcular"></button> -->
						</td>
						<td><input type="text" disabled size="8" id="txtNuevoSalario_<?=$nomina_item['legajo']?>" name="txtNuevoSalario_<?=$nomina_item['legajo']?>"/></td>	
						<td><?=$nomina_item['app_status']?></td>
						<td>
							<!-- <input type="submit" value="Guardar"/> -->
						</td>
				<?php
				}
				?>		
				
				<?php
					if($nomina_item['app_status']=='APROBADO' ||
						$nomina_item['app_status']=='FINALIZADO'||
						$nomina_item['app_status']=='REVISAR'
					){
				?>
						<td><input type="text" disabled size="8" id="txtAjusteSalario_<?=$nomina_item['legajo']?>" name="txtAjusteSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_porcentaje_propuesto']?>"/></td>
						<td></td>
						<td><input type="text" disabled size="8" id="txtNuevoSalario_<?=$nomina_item['legajo']?>" name="txtNuevoSalario_<?=$nomina_item['legajo']?>" value="<?=$nomina_item['app_salario_propuesto']?>"/></td>		
						<td><?=$nomina_item['app_status']?></td>
						<td></td>
				<?php
				}
				?>	
					<!-- <input type="submit" onclick="window.location.href='http://localhost/cencosud/salarymanagementadmin/notificarEmpleado'"value="Guardar"/> -->
			</tr>
			</form>
		<?php
		endforeach;
		?>
	</table>
	<div></div>
</div>

<!-- NUEVA COMPENSACION -->
<div id="nuevaCompensacion" class="tabcontent" name="nuevaCompensacion">
	<?php
		$this->table->set_heading(array('Nombre', 'Bonos', 'Salario Anual', 'Salario Anual USD', 'Compra-Ratio', 'Rango', 'Compra-Ratio Dif'));
		foreach ($nomina as $nomina_item):
			if($nomina_item['app_salario_propuesto']>0){
				$this->table->add_row(
					$nomina_item['nombre_completo'],
					$nomina_item['bonos_totales'],
					($nomina_item['app_salario_propuesto']*$nomina_item['salarios_anuales']),
					($nomina_item['app_salario_propuesto']*$nomina_item['salarios_anuales']/$parametros->tipo_cambio),
					'TBD',
					$nomina_item['comp_pos_de_rango'],
					'TBD'
					);
			}else{
				$this->table->add_row(
					$nomina_item['nombre_completo'],
					$nomina_item['bonos_totales'],
					($nomina_item['salario_enero']*$nomina_item['salarios_anuales']),
					($nomina_item['salario_enero']*$nomina_item['salarios_anuales']/$parametros->tipo_cambio),
					'TBD',
					$nomina_item['comp_pos_de_rango'],
					'TBD'
					);
			}			// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
		endforeach;
		echo $this->table->generate();
	?>
</div>

<!-- ALERTAS -->
<div id="alertas" class="tabcontent" name="alertas">
	<?php
		$this->table->set_heading(array('Nombre', 'Pauta', 'Eval. Desempeño', 'Prioridad', 'Rango', 'Fecha Ingreso'));
		foreach ($nomina as $nomina_item):
			
			/* Alerta Pauta */
			$alertaPauta="";
			if($nomina_item['app_porcentaje_propuesto']>$nomina_item['comp_pauta']){
				$alertaPauta='% propuesto excede Pauta';
			}

			/* Alerta Evaluacion Desempeño */
			$alertaEval = "";
			if($nomina_item['comp_eval_desempeno']!=$parametros->alerta_eval){
				$alertaEval='Por debajo';
			}

			/* Prioridad ajuste */
			$alertaPrioridad = "";
			if($nomina_item['comp_prioridad_ajuste']=='Sin Incremento' || $nomina_item['comp_prioridad_ajuste']==NULL){
				$alertaPrioridad='Sin Incremento';
			}

			/* Fecha de ingreso */
			$alertaIngreso = "";
			if($nomina_item['fecha_ingreso']>=$parametros->alerta_fecha_ingreso){
				$alertaIngreso='Mayor a '.$parametros->alerta_fecha_ingreso;
			}


			$this->table->add_row(
				$nomina_item['nombre_completo'],
				$alertaPauta,
				$alertaEval,
				$alertaPrioridad,
				'TBD',
				$alertaIngreso
				);


			// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
		endforeach;
		echo $this->table->generate();
		?>		  
</div>

<!-- COMENTARIOS -->
<div id="comentarios" class="tabcontent" name="comentarios">
	<!-- Con tablas HTML -->
	<table>
		<thead>
			<th>Legajo</th>	
			<th>Nombre</th>
			<th>Comentarios</th>
		</thead>
		<?php
		foreach ($nomina as $nomina_item):
			echo validation_errors();
			echo form_open('SalaryManagementAdminJefe/updateObservaciones');
		?>
			<tr>
				<td><input type="text" size="8" id="txtLegajo" name="txtLegajo" value="<?php echo $nomina_item['legajo'];?>"/></td>
				<td><?php echo $nomina_item['nombre_completo'];?></td>
				<td><input type="text" size="100" id="txtObservacionesEmpleado" name="txtObservacionesEmpleado" value="<?php echo $nomina_item['app_observaciones'];?>"/></td>
				<td>
				<input type="submit" value="Guardar"/>
				</td>
			</tr>
		</form>
		<?php
		endforeach;
		?>
	</table>
	<div></div>
</div>

<!-- OLD -->

<?php
	/*
	$template = array(
        'table_open'  => '<table border="1" cellpadding="2" cellspacing="1" class="mytable">'
	);
	$this->table->set_template($template);
	*/
	
	/*
	$this->table->set_heading(array('Nombre completo', 'Email', 'País', 'Nivel', 'Base', 'Edit'));

	foreach ($nomina as $nomina_item):
		
		$this->table->add_row(
				$nomina_item['nombre_completo'], 
				$nomina_item['email'],
				$nomina_item['pais'],
				$nomina_item['nivel_ejecutivo'],
				$nomina_item['base_importe_calculo_bono'],
				'<a href='.site_url('salarymanagementadmin/viewDetail/'.$nomina_item['legajo'].'>Ver</a>')
			);

		// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
	endforeach;
	
	echo $this->table->generate();
	*/
?>





