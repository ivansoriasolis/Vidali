<?php
require_once 'core_user.class.php';

class CORE_PROFILE extends CORE_USER{
	/*Private*/
	private function acept_friend($_id,$_idsender){
		$connection = parent::connect();
		$query = ("UPDATE vdl_friend_of SET status=1 WHERE user2=$_id AND user1=$_idsender AND status=0");
		echo $query;
		$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));
		if($result){
//			$query = ("INSERT INTO vdl_notify (user_id,user_sender,type,checked) VALUES ('$_candidate','$_main','1','0')");
//			$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));		
			return true;
		}
		else
			return false;		
	}
	
	private function add_friend($_main,$_candidate,$_range){
		$connection = parent::connect();
		$query = ("INSERT INTO vdl_friend_of (user1,user2,status) VALUES ('$_main','$_candidate','0')");
		$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));
		if($result){
			$query = ("INSERT INTO vdl_notify (user_id,user_sender,type,checked) VALUES ('$_candidate','$_main','1','0')");
			$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));		
			return true;
		}
		else
			return false;
	}
	
	private function delete_friend($_main,$_friend){
		$connection = parent::connect();
		$query = ("DELETE FROM  vdl_friend_of 
				   WHERE (vdl_friend_of.user1 ='$_main' AND vdl_friend_of.user2='$_friend')
				   OR (vdl_friend_of.user1 ='$_friend' AND vdl_friend_of.user2='$_main')");
		$result = mysql_query($query,$connection);
		$result = mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message = $message.' Whole query: ' . $query;
			die($message);
			return false;
		}
		return true;
	}

	private function block_enemy($_main,$_friend){
		$connection = parent::connect();
		$query = ("UPDATE vdl_friend_of SET status='2' WHERE vdl_friend_of.user1 ='$_main' AND vdl_friend_of.user2='$_friend'");
		$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));
		parent::close($connection);
		if(!result)
		return false;
		else
		return true;
	}
	 
	private function add_trend($text){
		preg_match_all('/[#]+([A-Za-z0-9-_]+)/',$text, $hash); 
		$hashtag = $hash[1]; 
		foreach($hashtag  as $key => $hash){ 
			$ht=ucwords(strtolower($hash));
			$connection = parent::connect();
			$query = ("SELECT topic FROM vdl_trending WHERE topic='$ht'");
			echo $query;
			$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));
			if(!$result)
				return false;
			if(mysql_num_rows($result) == 0){
				$query = ("INSERT INTO vdl_trending (topic,count) VALUES ('$ht',1)");
				$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));			
				if(!$result)
					return false;
			}
			else{
				$query = ("UPDATE vdl_trending SET count =count+1 WHERE topic='$ht'");
				$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));					
				if(!$result)
					return false;
			}
		} 
		return true;
	}
	/*Public*/

	public function __construct (){
		parent::__construct();
	}

	public function create($_user_id,$_passwd,$_nickname,$_name,$_location,$_genre,$_bday,$_email,$_bio){
		$query = ("INSERT INTO vdl_user (user_id,passwd,nickname,name,location,genre,bday,email,bio,img_prof) VALUES
					 ('$_user_id','$_passwd','$_nickname','$_name','$_location','$_genre','$_bday','$_email','$_bio','prof_def')");
		$result = mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message = 'Whole query: ' . $query;
			die($message);
		}
	}
	
	public function get_profile($_user,$_refer){
		$connection = parent::connect();
		$a_result1 = parent::get_user($_user, $_refer);
		$query = sprintf("SELECT vdl_user.id FROM vdl_user WHERE vdl_user.nick='%s'", $_user);
		$result=mysql_query($query,$connection);
		$id = mysql_fetch_assoc($result);
		$a_result1 = array();
		$query = sprintf("SELECT vdl_u_belong.group_id FROM vdl_u_belong WHERE vdl_u_belong.user_id='%s'", $id["id"]);
		$result=mysql_query($query,$connection);
		while ($rowa = mysql_fetch_assoc($result)){
			$query1 = ("SELECT net_name,net_sdesc,net_img FROM vdl_net WHERE vdl_net.id='".$rowa["id_net"]."'");
			$result1 = mysql_query($query1,$connection);
			while ($row = mysql_fetch_assoc($result1)){
				array_push($a_result1,$row);
			}
		}
		$a_result2 = array();
		//consulta chachi aki, join para users y status
/*		$query = "SELECT b.nick,c.nick,b.avatar_id,c.avatar_id,status
						  FROM vdl_friend_of a
						  JOIN vdl_user b ON b.id = a.user1
						  JOIN vdl_user c ON c.id = a.user2
						  WHERE (a.user1='".$id["id"]."' OR a.user2='".$id["id"]."')
						  LIMIT 0 , 30";*/
		$query = "SELECT * FROM vdl_friend_of WHERE (user1='".$id["id"]."' OR user2='".$id["id"]."') LIMIT 0,10";
		$result = mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message =  $message . ' Whole query: ' . $query;
			die($message);
		}
		while ($row = mysql_fetch_assoc($result)){
			if($row["status"] != 0){
				if($row["user1"]==$id["id"]){
					$query = "SELECT nick,avatar_id FROM vdl_user WHERE id='".$row["user2"]."'";
					$result2 = mysql_query($query,$connection);	
				}
				else{
					$query = "SELECT nick,avatar_id FROM vdl_user WHERE id='".$row["user1"]."'";
					$result2 = mysql_query($query,$connection);	
				}
				while($row2 = mysql_fetch_assoc($result2))
				array_push($a_result2,$row2);
			}
		}
		if($_user != $_refer){
			$query = ("UPDATE vdl_user a SET `n_views` = `n_views` + 1 WHERE a.nick ='$_user'");
			$result = mysql_query($query,$connection);
			if (!$result) {
				$message = 'Invalid query: ' . mysql_error() . "\n";
				$message = $message. ' Whole query: ' . $query;
				die($message);
			}
		}

		$result = array();
		array_push($result,$a_result1);
		array_push($result,$a_result2);
		array_push($result,$id);

		
		return $result;
	}

	public function get_networks($_user){
		$connection = parent::connect();
		$query = sprintf("SELECT vdl_user.id FROM vdl_user WHERE vdl_user.user_id='%s'", $_user);
		$result=mysql_query($query,$connection);
		$id = mysql_fetch_assoc($result);
		$a_result1 = array();
		$query = sprintf("SELECT vdl_u_belong.id_net FROM vdl_u_belong WHERE vdl_u_belong.id_user='%s'", $id["id"]);
		$result=mysql_query($query,$connection);
		while ($rowa = mysql_fetch_assoc($result)){
			$query1 = ("SELECT net_name FROM vdl_net WHERE vdl_net.id='".$rowa["id_net"]."'");
			$result1 = mysql_query($query1,$connection);
			while ($row = mysql_fetch_assoc($result1)){
				array_push($a_result1,$row);
			}
		}
		return $a_result1;
	}
	
	
	public function get_updates($_user){
		$connection = parent::connect();
		$query = sprintf("SELECT id, nick, b.avatar_id, date_published,text
						  FROM vdl_publish a
						  JOIN vdl_user b ON b.id = id_user
						  JOIN vdl_group ON vdl_group.group_name = id_group
						  JOIN vdl_msg ON vdl_msg.id_msg = a.id_msg
						  WHERE b.nick =  '%s'
						  ORDER BY  `vdl_msg`.`date_published` DESC 
						  LIMIT 0 , 30", $_user);
		$result=mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		//mostrar resultado
		$arresult=array();
		while ($row = mysql_fetch_array($result)) {
			array_push($arresult,$row);
		}
		return $arresult;
	}
	
	public function get_home_wall($_user){
		$connection = parent::connect();
		$query = "SELECT id from vdl_user WHERE nick = '$_user'";
		$result=mysql_query($query,$connection);
		$id = mysql_fetch_assoc($result);
		$query = "SELECT id, nick, b.avatar_id, date_published,text
					FROM vdl_publish a
					JOIN vdl_user b ON b.id = id_user
					JOIN vdl_group ON vdl_group.group_name = id_group
					JOIN vdl_msg ON vdl_msg.id_msg = a.id_msg
					WHERE b.id
					IN ( SELECT a.id
						 FROM vdl_user a
						 INNER JOIN vdl_friend_of b
						 WHERE (a.id = b.user1 OR a.id = b.user2)
						 AND ( b.user1 ='".$id["id"]."' OR b.user2 ='".$id["id"]."')
						 AND ( b.status != 0)
					)
					ORDER BY  `vdl_msg`.`date_published` DESC 
					LIMIT 0 , 30";
		$result=mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		//mostrar resultado
		$arresult=array();
		while ($row = mysql_fetch_array($result)) {
			array_push($arresult,$row);
		}
		return $arresult;
	}
	
	
	public function delete(){
		
	}

	public function modify(){
	
	}
	
	public function set_privacy(){
	
	}
	
	public function update($_user,$_message,$_s_id){
		$connection = parent::connect();
		date_default_timezone_set('Europe/London');
		$date = date("Y-m-d G:i:s");
		$text = $_message;
//		$text = htmlentities($_message,ENT_QUOTES,"UTF-8");
		$query = ("SELECT id,nick FROM  `vdl_user` WHERE  `session_id` =  '".$_s_id."'");
		$result = mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
			return false;
		}
		$this->add_trend($text);
		preg_match_all('/[#]+([A-Za-z0-9-_]+)/',$text,$hash);
		$hashtag = $hash[1];
		foreach($hashtag  as $key => $hash){ 
			//Aqui podemos hacer que lo agrege a la database 
			$find = '#'.$hash;
			$replace = '#'.ucwords(strtolower($hash)); 
			$text = str_replace($find, $replace, $text); 
		}
		$user = mysql_fetch_assoc($result);
		$query = ("INSERT INTO vdl_msg (date_published,text) VALUES ('$date', '$text')");
		$result = mysql_query($query,$connection) or die(mysql_error('Ups, algo falla a la hora de postear...prueba luego.'));	
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
			return false;
		}
		if( $user["nick"] == $_user){
			$user = $user["id"];
			$msg_id = mysql_insert_id($connection);
			$query = ("INSERT INTO vdl_publish (id_user,id_msg,id_group) VALUES ('$user', '$msg_id','Vidali')");
			$result = mysql_query($query,$connection);	
			if (!$result) {
				$message  = 'Invalid query: ' . mysql_error() . "\n";
				$message .= 'Whole query: ' . $query;
				die($message);
				return false;
			}
			
		}
		else
			return false;
		return true;
	}
	
	public function join_network(){
	
	}
	
	public function manage_friend($_req,$_main,$_candidate,$_range){
		$connection = parent::connect();
		if($_req == "add"){
			$sucess = $this->add_friend($_main, $_candidate, $_range);
		}
		if($_req == "delete" || $_req == "reject"){
			$sucess = $this->delete_friend($_main, $_candidate);
		}
		if($_req == "acept"){
			$sucess = $this->acept_friend($_main, $_candidate);
		}
		if($_req == "block"){
			$sucess = $this->block_enemy($_main, $_candidate);
		}
		if ($sucess == true)
			return true;
		else
			return false;
	}
	
	
	public function add_note(){
	
	}
	
	public function add_file(){
	
	}
	
	public function get_notify($_user){
		$connection = parent::connect();
		$query = "SELECT a.id,a.user_id,a.user_sender,a.type,a.checked 
				  FROM vdl_notify a 
				  JOIN vdl_user b ON a.user_id = b.id  WHERE b.nick = '$_user' AND a.checked = 0";
		$result=mysql_query($query,$connection);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		//mostrar resultado
		$arresult=array();
		while ($row = mysql_fetch_array($result)) {
			
			array_push($arresult,$row);
		}
		return $arresult;
	}
	
	public function meta_text($text){
		$text = html_entity_decode($text);
		//Comprobamos las Menciones 
		preg_match_all ("/[@]+([A-Za-z0-9-_]+)/",$text, $users); 
		foreach($users[1]  as $key => $user){ 
			$find = '@'.$user; 
			$replace = '<b><a href="?pg=p&!=all&@='.$user.'" >@'.$user.'</a></b>'; 
			$text = str_replace($find, $replace, $text); 
		} 
		 
		//Comprobamos los Hashtag 
		$text = preg_replace('/[#]+([A-Za-z0-9-_]+)/',
        '<b><a href="?pg=g&!=all&q=%23\1">#\1</a></b>',
        $text);

/*		preg_match_all('/[#]+([A-Za-z0-9-_]+)/',$text,$hash);
		$hashtag = $hash[1];
		foreach($hashtag  as $key => $hash){ 
			//Aqui podemos hacer que lo agrege a la database 
			$find = '#'.$hash;
			$replace = '<b><a href="?pg=g&!=all&q=%23'.$hash.'" >#'.$hash.'</a></b>'; 
			$text = str_replace($find, $replace, $text); 
		} */

		//Comprobamos las redes
		preg_match_all('/[!]+([A-Za-z0-9-_]+)/',$text, $ntag);
		foreach($ntag[1]  as $key => $net){
			//Aqui podemos hacer que lo agrege a la database
			$find = '!'.$net;
			$replace = '<b><a href="?pg=n&name='.$net.'" >!'.$net.'</a></b>';
			$text = str_replace($find, $replace, $text);
		}

		//Comprobamos los t�tulos
		preg_match_all ("/>\*([A-Za-z0-9-_\s]+)\*</",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = '>*'.$black.'*<';
			$replace = '<u><h1>'.$black.'</h1></u>';
			$text = str_replace($find, $replace, $text);
		}
		
		
		//Comprobamos las Negritas
		preg_match_all ("/\*([A-Za-z0-9-_\s]+)\*/",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = '*'.$black.'*';
			$replace = '<b>'.$black.'</b>';
			$text = str_replace($find, $replace, $text);
		}

		//Comprobamos las cursivas
		preg_match_all ("/_([A-Za-z0-9-_\s]+)_/",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = '_'.$black.'_';
			$replace = '<i>'.$black.'</i>';
			$text = str_replace($find, $replace, $text);
		}
		
		//Comprobamos los tachados
		preg_match_all ("/-([A-Za-z0-9-_\s]+)-/",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = '-'.$black.'-';
			$replace = '<strike>'.$black.'</strike>';
			$text = str_replace($find, $replace, $text);
		}

		//Comprobamos los links youtube
		preg_match_all ("/http:\/\/www\.youtube\.com\/watch\?v=([A-Za-z0-9-_]+)/",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = 'http://www.youtube.com/watch?v='.$black;
			$replace = '<br/><iframe width="420" height="315" src="http://www.youtube.com/embed/'.$black.'?wmode=transparent"  frameborder="0" allowfullscreen></iframe><br/>';
			$text = str_replace($find, $replace, $text);
		}
		//http://img.youtube.com/vi/sEhy-RXkNo0/default.jpg para la vista previa de la imagen

		//Comprobamos los links youtube https
		preg_match_all ("/https:\/\/www\.youtube\.com\/watch\?v=([A-Za-z0-9-_]+)/",$text, $blacks);
		foreach($blacks[1]  as $key => $black){
			$find = 'https://www.youtube.com/watch?v='.$black;
			$replace = '<br/><iframe width="420" height="315" src="http://www.youtube.com/embed/'.$black.'?wmode=transparent"  frameborder="0" allowfullscreen></iframe><br/>';
			$text = str_replace($find, $replace, $text);
		}
		//http://img.youtube.com/vi/sEhy-RXkNo0/default.jpg para la vista previa de la imagen
		
		return $text;
	}
}

?>
