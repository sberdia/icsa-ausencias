	<script type="text/javascript" src="<?php echo base_url();?>js/calendar.js"></script>

	<blockquote>
		<p><em>Importar datos</em></p>
	</blockquote>

	<?php 
		echo $error;
		// echo validation_errors();
		echo form_open_multipart('ImportData/do_upload');
	?>
<!-- 
<input type="file" name="userfile" size="20"/>
				<br>
				<input class="button" type="submit" value="Subir archivo" />
		</form>
-->
<div>
		<table id="tblImportData" name="tblImportData">
			<thead>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
				<th></th>
			</thead>
			<tbody>
				<tr>
					<td>Fecha efectiva: <input size="10" id="fechaEfectiva" name="fechaEfectiva" type="text" READONLY title="YYYY-MM-DD"></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>	
					<td><input type="file" id="dataFile" name="dataFile" size="20" /></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><input class="button" type="submit" value="Subir archivo" /></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</tbody>
		</form>
		</table>
	</div>
