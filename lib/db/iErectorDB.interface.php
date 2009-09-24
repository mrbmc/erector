<?php

interface iErectorDB
{
	function __construct($dsn);

	function connect($dsn);

	function query($sql);

	function query_first($sql);

	function fetch_array($query_id);

	function query_write($table, $matchcolumn, $data);

	function num_rows($resource);
	
	function insert_id($resource);

	function build_sql ($table, $matchcolumn, $data);
}

?>