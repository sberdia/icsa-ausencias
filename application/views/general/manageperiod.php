<script type="text/javascript" src="<?php echo base_url();?>js/calendar.js"></script>

<div>
  	<button class="button button-outline" onclick="openCity(event, 'nuevoPeriodo')">Alta Períodos</button>
  	<button class="button button-outline" onclick="openCity(event, 'listaPeriodo')">Consultar</button>
</div>
<div id="nuevoPeriodo" class="tabcontent" name="nuevoPeriodo">
	<?php
			echo validation_errors();
			echo form_open('manageperiod');
	?>
	<div>
		<table id="tblPeriodo" name="tblPeriodo">
			<thead></thead>
			<tbody>
			<tr>
				<td>País:</td>
				<td>
				<select id="periodPais" name="periodPais">
					<option value="ARGENTINA">ARGENTINA</option>
					<option value="CHILE">CHILE</option>
					<option value="BRASIL">BRASIL</option>
					<option value="PERU">PERU</option>
				</select>		
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Inicio Período: </td>
				<td><input size="10" id="periodInicio" name="periodInicio" type="text" READONLY title="YYYY-MM-DD"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Fin Periodo: </td>
				<td><input size="10" id="periodFin" name="periodFin" type="text" READONLY title="YYYY-MM-DD"></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Habilitado: </td>
				<td>
					<select id="periodHabilitado" name="periodHabilitado">
						<option value="SI">SI</option>
						<option value="NO">NO</option>
					</select>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Estado:</td>
				<td>
				<select id="periodEstado" name="periodEstado">
						<option value="ACTIVO">ACTIVO</option>
						<option value="INACTIVO">INACTIVO</option>
					</select>

				</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
			</tbody>
		</table>
	</div>
	<div><input type="submit" value="Guardar"/></div>
	<?php
		echo('</form>');
	?>
</div>

<div id="listaPeriodo" class="tabcontent" name="listaPeriodo">
	<blockquote>
		<p><em>Consultas de períodos</em></p>
	</blockquote>
	<?php
		$this->table->set_heading(array('Pais', 'Inicio', 'Fin', 'Hablitado', 'Estado'));
		foreach ($period as $period_item):
			$this->table->add_row(
				$period_item['pais'],
				$period_item['fecha_inicio'],
				$period_item['fecha_fin'],
				$period_item['habilitado'],
				$period_item['estado']
				);
			// url nomina: site_url('salarymanagementadmin/view/'.$nomina_item['legajo']))
		endforeach;
		echo $this->table->generate();
	?>
</div>

<!--<div>
	País: 
	<select>
	<option value="ARG">Argentina</option>
	<option value="CHI">Chile</option>
	<option value="BRA">Brasil</option>
	<option value="PER">Perú</option>
	</select><br>
	Inicio Período:<br>
	Fin Periodo:<br>
	Habilitado:
	<select>
	<option value="SI">Si</option>
	<option value="NO">No</option>
	</select><br>
	Estado:
	<select>
	<option value="activo">Activo</option>
	<option value="inactivo">Inactivo</option>
	</select><br>
</div>
-->
