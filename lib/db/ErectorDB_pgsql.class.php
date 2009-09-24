<?php

class ErectorDB_child
{

	private $conn = 0;

	function __construct($dsn) {
		return $this->connect($dsn);
	}

	function connect($dsn) {
		$this->conn = pgsql_connect($dsn['host'], $dsn['user'], $dsn['pass']) or die(pgsql_error());;
		pgsql_select_db($dsn['db'], $this->conn);
		return true;
	}

	function query($q) {
		$result = pgsql_query($q, $this->conn);
		if (!$result) {
			die("Invalid query -- $q -- " . pgsql_error());
		}
		return $result;
	}

	function fetch_array($query_id, $type = PGSQL_ASSOC)
	{
		// retrieve row
		return pgsql_fetch_array($query_id, $type);
	}

	function free_result($query_id)
	{
		// retrieve row
		return pgsql_free_result($query_id);
	}

	function query_first($query_string, $type = PGSQL_ASSOC)
	{
		// does a query and returns first row
		$query_id = $this->query($query_string);
		$returnarray = $this->fetch_array($query_id, $type);
		$this->free_result($query_id);
		$this->lastquery = $query_string;
		return $returnarray;
	}


}

?>