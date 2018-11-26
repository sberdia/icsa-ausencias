<?php
	echo validation_errors();
?>
	<table style="width: 25%; margin: 0 auto; text-align: left;">
	<?php
		echo form_open('main');	
	?>
		<tr>
			<td class="tdLogin"><label for="nameField">Usuario</label></td>
		</tr>
		<tr>
			<td class="tdLogin"><input type="text" size="15" placeholder="Usuario" id="username" name="username"></td>
		</tr>
		<tr>
			<td class="tdLogin"><label for="password">Contraseña</label></td>
		</tr>
		<tr>
			<td class="tdLogin"><input type="password" size="15" placeholder="Contraseña" id="password" name="password"></td>
		</tr>
		<tr>
			<td class="tdLogin"><input class="button-primary" type="submit" value="Ingresar"></td>
		</tr>
	</table>
  </form>


