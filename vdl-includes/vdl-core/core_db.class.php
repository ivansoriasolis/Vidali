<?php 
class CORE_DB{
	/*Private*/
	private $_conecction; // We store the MySQL connection here 

	/*Public*/

	/**
	 * 
	 * We start to parse "db.ini" that stores the main info to connect to MySQL server. 
	 */
	public function __construct (){
		$config=parse_ini_file("db.ini",true);
		define ("DBDIR",$config["DB"]["DBDIR"]);
		define ("DBUSR",$config["DB"]["DBUSR"]);
		define ("DBPSW",$config["DB"]["DBPSW"]);
		define ("DBASE",$config["DB"]["DBASE"]);
	}

	/**
	 * 
	 * We close MySQL connection here.
	 */
	public function __destruct(){
		mysql_close($this->_connection);
	}

	/**
	 * 
	 * We start the connection to MySQL server. Return the connection value and also saves in $_connection.
	 */
	public function connect (){
		$connection = mysql_connect(DBDIR, DBUSR , DBPSW) or die ("Error: No conecta. Usuario/contrase�a erroneo o direccion incorrecta.");
		$database = DBASE;
		mysql_select_db($database, $connection) or die ("Error: No conecta a la base de datos.");
		$this->_conecction = $connection;
		return $connection;
	}

	/**
	*
	* We modify db.ini with the new values given.
	* @param $_dbdir: Store new MySQL dir.
	* @param $_dbusr: Store new MySQL username.
	* @param $_dbpsw: Store new MySQL password.
	* @param $_dbase: Store new MySQL database.
	*/
	public function set($_dbdir,$_dbusr,$_dbpsw,$_dbase){
		$file = fopen("../vdl-includes/vdl-core/db.ini","w");
		$string="[DB]\nDBDIR=$_dbdir\nDBUSR=$_dbusr\nDBPSW=$_dbpsw\nDBASE=$_dbase";
		fputs($file,$string);
		fclose($file);
	}
}
?>