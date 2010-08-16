<?php
include_once LIB.'/db/iErectorDB.interface.php';
class ErectorDB_mysql implements iErectorDB
{

	private $db;
	private $conn;
	private $dsn;

	function __construct($dsn) {
		return $this->connect($dsn);
	}

	function connect($dsn) {
		$this->conn = mysql_connect($dsn['host'], $dsn['user'], $dsn['pass']) or die(mysql_error());;
		mysql_select_db($dsn['db'], $this->conn);
		$this->dsn =& $dsn;
		return true;
	}

	function query($q) {
		$result = mysql_query($q, $this->conn);
		if (!$result) {
			die("Invalid query -- $q -- " . mysql_error());
		}
		$this->lastquery = $q;
		return $result;
	}

	function query_first($query_string, $type = MYSQL_ASSOC)
	{
		// does a query and returns first row
		$query_id = $this->query($query_string);
		$returnarray = $this->fetch_array($query_id, $type);
		$this->lastquery = $query_string;
		return $returnarray;
	}

	function query_write($table, $matchcolumn, $data) {
		$sql = $this->build_sql($table,$matchcolumn,$data);
		return $this->query($sql);
	}

	function fetch_array($query_id, $type = MYSQL_ASSOC)
	{
		// retrieve row
		return mysql_fetch_array($query_id, $type);
	}

	function num_rows($query_id){
		$result = mysql_query("SELECT FOUND_ROWS()", $this->conn);
//		return mysql_num_rows($query_id);
	}

	function insert_id($resource) {
		if($resource==null)
			$resource = $this->conn;
		return mysql_insert_id($resource);
	}

	function build_sql ( $__tableName, $__matchColumn, $__data ){
		$fieldresults = $this->query("SHOW COLUMNS FROM $__tableName");

		//	UPDATE STATEMENTS
		if( $__data[$__matchColumn] ) {
			$statement = "UPDATE " . $__tableName . " SET ";
			$addspace = false;
			while($field = $this->fetch_array($fieldresults)) 
			{
				$this_field = $field['Field'];
				if( isset($__data[$this_field]) ){
					if( $this_field != $__matchColumn ) {
						if( $addspace )
							$statement .= ", ";
						$statement .= $this_field . "='" . mysql_real_escape_string($__data[$this_field]) . "'";
						$addspace = true;
					}
				}
			}
			$statement .= " WHERE " . $__matchColumn . "='" . $__data[$__matchColumn] . "'";
		//	INSERT STATEMENTS
		} else {
			$statement = "INSERT INTO " . $__tableName;
			$columnlist = "(";
			$valuelist = "(";
			$addspace = false;
			while($field = $this->fetch_array($fieldresults)) 
			{
				$this_field = $field['Field'];
				if( isset($__data[$this_field]) ){
					if( $this_field != $__matchColumn ) {
						if( $addspace ){
							$columnlist .= ", ";
			     			$valuelist .= ", ";
						}
						$columnlist .= $this_field;
						$valuelist .= "'" . mysql_real_escape_string($__data[$this_field]) . "'";
						$addspace = true;
					}
				}
			}
			$columnlist .= ")";
			$valuelist .= ")";
			$statement .= " " . $columnlist . " values " . $valuelist;
		}
		//	finally, return the insert statement
		return $statement;
	}

}

?>