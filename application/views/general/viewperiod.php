<?php
			echo validation_errors();
			echo form_open('SalaryManagementAdmin');
		?>
		<table>
			<thead>
			</thead>
			<tbody>
				<tr>
				<td>
					<select id="periodoPais" name="periodoPais">
					<?php
					foreach ($periodo as $periodo_item):
					?>
						<option value="<?=$periodo_item['id_periodo']?>">País: <?=$periodo_item['pais']?> :: Período: <?=$periodo_item['fecha_inicio'].' - '.$periodo_item['fecha_fin']?></option>
					<?php
					endforeach;
					?>
					</select>
				</td>
				<td>
					<!-- <input type="button" id="btnSeleccionPeriodo" name="btnSeleccionPeriodo" value="Seleccionar"/>-->
					<input type="submit" id="btnSeleccionPeriodo" name="btnSeleccionPeriodo" value="Seleccionar"/>
				</td>
			</tbody>
		</table>
		</form>
