<blockquote>
	<p><em>Notificaciones</em></p>
</blockquote>

<?php
	echo validation_errors();
	echo form_open('salarymanagementadmin/notificarModificaciones');
?>
	<input type="submit" value="Notificar"/>
</form>

<blockquote>
	<p><em>Generar PDF</em></p>
</blockquote>

<?php
	echo validation_errors();
	echo form_open('salarymanagementadmin/generarPDF');
?>
	<input type="submit" value="PDF"/>
</form>
