<?php
/*	Vidali, Social Network Open Source.
This file is part of Vidali.

Vidali is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Vidali is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.*/

$set = $_GET["func"];
//===>Check session
if ($set == "login"){
?>
	Iniciar secion en vidali:<br/>
	<form action="vdl-includes/session_start.php" method="post">
		<label>usuario:</label><br/><input id ="user" name="user" size="40" type="text" /><br/>
		<label>contraseña:</label><br/><input id ="passwd" name="passwd" size="40" type="password" /><br/>
		<center><input type="submit" value="Iniciar sesion"></center>
	</form>
<?php
}
else{
	session_start();
	$_SESSION = array();
	if (ini_get("session.use_cookies")) 
	{
    	$params = session_get_cookie_params();
    	setcookie(session_name(), '', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);
	}
	session_destroy();
	header("location: ../index.php");
}
?>
