<?php

class ErectorDB_oracle
{

	private $conn = 0;

	function __construct($dsn) {
		return $this->connect($dsn);
	}

	function connect($dsn) {
		//$this->conn = mysql_connect($dsn['host'], $dsn['user'], $dsn['pass']) or die(mysql_error());;
		//mysql_select_db($dsn['db'], $this->conn);
		$this->conn = oci_connect($dsn['user'], $dsn['pass'], $dsn['db']);
		if (!$this->conn) {
			$e = oci_error();
			print htmlentities($e['message']);
			exit;
		}
		return $this->conn;

	}

	function query($query) {
		$stid = oci_parse($this->conn, $query);
		if (!$stid) {
			$e = oci_error($this->conn);
			print htmlentities($e['message']);
			exit;
		}
		
		$r = oci_execute($stid, OCI_DEFAULT);
		if (!$r) {
			$e = oci_error($stid);
			echo htmlentities($e['message']);
			exit;
		}
	}

	function fetch_array($query_id, $type = OCI_RETURN_NULLS)
	{
		// retrieve row
		return oci_fetch_array($query_id, $type);
	}

	function query_first($query, $type = MYSQL_ASSOC)
	{
		// does a query and returns first row
		$query_id = $this->query($query);
		$returnarray = $this->fetch_array($query_id, $type);
		$this->lastquery = $query;
		return $returnarray;
	}


}

?>