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
	$prof = new CORE_PROFILE();
	$author = $prof->get_home($_SESSION["user_id"]);
	$nick = $prof->nickname();
	$p_visits = $prof->prof_visits();
	$p_friends = $prof->prof_friends();
	$p_nets = $prof->prof_nets();
	$photo = $prof->img_prof();
	if(isset($_GET["!"]))
		$stream="all";
?>

<aside id="left" class="grid_4">
	sugerencias y demas...
</aside>

<div class="grid_12"> 
	<div id="home_titles"> Actividad Reciente </div>
	<div class="home_breadcumbs"> Amigos | redes | menciones | Titulares</div>
	<div class="home_update"> ejemplo de update</div>
</div>
<div class="clear"></div>
