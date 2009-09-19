<?php

class SimpleDB
{

	private $db = 0;

	function __construct($dsn) {
		include_once 'SimpleDB.'.$dsn['type'].'.class.php';
		$this->db = new SimpleDB_child($dsn);
		return $this->db;
	}

	private function connect($dsn) {
		return $this->db->connect($dsn);
	}

	function query($sql) {
		return $this->db->query($sql);
	}

	function query_first($sql)
	{
		return $this->db->query_first($sql);
	}

	function fetch_array($query_id)
	{
		return $this->db->fetch_array($query_id);
	}

	function query_write($table, $matchcolumn, $data) {
		return $this->db->query($this->db->build_sql($table, $matchcolumn, $data));
	}

	function num_rows($resource) {
		return $this->db->num_rows($resource);
	}
	
	function insert_id($resource) {
		return $this->db->insert_id($resource);
	}

	function build_sql ($table, $matchcolumn, $data) {
		return $this->db->build_sql($table, $matchcolumn, $data);
	}

}

?>