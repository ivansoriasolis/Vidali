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

include_once 'vdl-core/core_main.class.php';
	$MAIN = new CORE_MAIN();
	$MAIN->load();

//invocamos a la clase login para iniciar la sesion
	include("vdl-core/core_security.class.php");
	$core= new CORE_SECURITY();
	if(!isset($_POST['remember']))
		$rem=0;
	else{
		$rem=$_POST['remember'];
	}
	$sucess= $core->login($_POST['user'], $_POST['password'],$rem);
	if($sucess == true)
		echo "1";
	else
		echo "0";	
?>
