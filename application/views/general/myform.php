<?php 

	defined('BASEPATH') OR exit('No direct script access allowed');

	if($session_logged_in == TRUE) {
		echo validation_errors();
		echo form_open('form');
		echo('<h5>User Logged In</h5>');
		echo $userSession;
		echo('</br>');
		echo $sessionId;
		echo('</br>');
		echo form_label("ETIQUETA");
		echo('<h5>Username</h5>');
		echo('<input type="text" name="username" value="');
		echo set_value('username');
		echo('" size="50" />');
		echo('<h5>Password</h5>');
		echo('<input type="text" name="password" value="');
		echo set_value('password');
		echo('" size="50" />');
		echo('<h5>Password Confirm</h5>');
		echo('<input type="text" name="passconf" value="');
		echo set_value('passconf');
		echo('" size="50" />');
		echo('<h5>Email Address</h5>');
		echo('<input type="text" name="email" value="');
		echo set_value('email');
		echo('" size="50" />');
		echo('<div><input type="submit" value="Submit" /></div>');
		echo('</form>');
	}

?>
