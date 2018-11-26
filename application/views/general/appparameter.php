<blockquote>
		<p><em>Parametros</em></p>
</blockquote>

	<?php
			echo validation_errors();
			echo form_open('AppParameter/updateEmailNotif');
	?>
		<table>
			<thead>
			</thead>
			<tbody>
				<tr>
					<td>Tipo de Cambio</td>
					<td><?=$applicationConfig->tipo_cambio;?></td>
				</tr>
				<tr>
					<td>Alerta Evaluación Desempeño</td>
					<td><?=$applicationConfig->alerta_eval;?></td>
				</tr>
				<tr>
					<td>Alerta Fecha Ingreso</td>
					<td><?=$applicationConfig->alerta_fecha_ingreso;?></td>
				</tr>
				<tr>
					<td>Email notificaciones</td>
					<td><input type="text" id="txtEmailNotif" name="txtEmailNotif" value="<?=$applicationConfig->mail_notif;?>"/></td>		
				</tr>
				<tr>
					<td><input type="submit" value="Guardar"/></td>
				</tr>
			</tbody>
		</table>
	</form>
