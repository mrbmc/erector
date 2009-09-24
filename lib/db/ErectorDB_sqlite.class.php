<?php

class ErectorDB_child
{

	private $conn = 0;
	private $errormsg = "";

	function __construct($dsn) {
		return $this->connect($dsn);
	}

	function connect($dsn) {
		//$this->conn = sqlite_open(getcwd() . "/code/db/" . $dsn['db'] . ".db");
		$path = getcwd() . "/code/db/" . $dsn['db'] . ".db";
	    $this->conn = new PDO('sqlite:'.$path); //sqlite 3
		return true;
	}

	function query($sql) {
		$result = $this->conn->prepare($sql);
		$result->execute();

		if (!$result) {
			die("Invalid query -- $q -- " . sqlite_error_string());
		}
		return $result;
	}

	function fetch_array($query_id)
	{
		// retrieve row
		return $query_id->fetch();
	}

	function query_first($query_string, $type = MYSQL_ASSOC)
	{
		// does a query and returns first row
		$query_id = $this->query($query_string);
		$returnarray = $this->fetch_array($query_id, $type);
		$this->lastquery = $query_string;
		return $returnarray;
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
						$statement .= $this_field . "='" . sqllite_real_escape_string($__data[$this_field]) . "'";
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
						$valuelist .= "'" . sqllite_real_escape_string($__data[$this_field]) . "'";
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