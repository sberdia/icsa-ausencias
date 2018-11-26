<?php
	if($session_logged_in == 1) {
		echo('User');
		echo print_r($ci_user);
		echo('<table>');
		echo('<tr>');
		echo('<th>Name</th>');
		echo('<th>Surname</th>');
		echo('</tr>');
		foreach($ci_user as $u){
			echo('<tr>');
			echo('<tr>');
			echo $u['user_email'];
			echo $u['user_pass'];
			echo('</tr>');
			echo('</tr>');
		}
		echo('</table>');
	}
?>
