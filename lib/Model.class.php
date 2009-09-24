<?php

abstract class Model {

	protected $sql;
	protected static $db;
	protected static $table;
	protected $matchColumn;

	/**
	 * @param mixed args a sql string, ID integer, or array of parameters
	 */
	function __construct($args=null)
	{
		self::$db =& Config::instance()->db;
		self::$table = strtolower(get_class($this));
		$this->matchColumn = self::$table.'id';

		if($args!=null) {
			$data = self::load($args);
			$this->set((array)$data[0]);
		}
	}

	/**
	 * @name load
	 * @param mixed args a string, integer, or array of parameters to create SQL
	 * @return array an array populated with Objects for the data found
	 */
	public static function load ($args=null) {
		// construct the SQL
		if(is_numeric($args)) {
			$sql_extra = "AND ".$this->getMatchColumn()."=".intval($args);
		} elseif(is_string($args)) {
			$sql_extra = $args;
		} else if(is_array($args)) {
			foreach($args as $k=>$v)
				$sql_extra .= "AND ".$k." LIKE '".$v."' ";
		}
		$sql = (stristr($sql_extra,"SELECT")!==false) ? $sql_extra : "SELECT * FROM ".self::$table." WHERE 1 ".$sql_extra;
		//Debugger::trace('sql',$sql,true);

		// make the query
		$results = self::$db->query($sql);
		$num_rows = self::$db->num_rows($results);

		//Parse the results
		$return = array();
		while($row = self::$db->fetch_array($results))
		{
			$classname = ucfirst(self::$table);
			$obj = new $classname();
			$obj->set($row);
			array_push($return, $obj);
		}
		return $return;
	}


	public function save ($_matchcolumn=null,$_data=null) {
		$matchcolumn = $this->getMatchColumn($_matchcolumn);
		if($_data==null)
			$_data = (array)$this;
		$this->sql = self::$db->build_sql(self::$table,$_matchcolumn,$_data);
		$saved = self::$db->query($this->sql); 
		if(stristr($this->sql,"INSERT")!==false && $saved==true)
			$this->$matchcolumn = self::$db->insert_id();
		return $saved;
	}


	public function delete ($_matchcolumn=null,$id) {
		$_matchcolumn = $this->getMatchColumn($_matchcolumn);
		$this->sql = "DELETE FROM ".self::$table." WHERE $_matchcolumn = '$id'";
		return self::$db->query($this->sql);
	}


	public function set ($_data) {
		$class_vars = get_class_vars(get_class($this));
		if (is_array($_data) && count($_data))
			foreach ($class_vars as $key => $val) 
				if (isset($_data[$key]) && property_exists($this,$key))
					$this->$key = $_data[$key];
		elseif (is_object($_data))
			foreach ($class_vars as $key => $val) 
				if (isset($_data->$key) && property_exists($this,$key))
					$this->$key = $_data->$key;
		return $this;
	}


	private function getMatchColumn ($mc) {
		if($mc==null)
			if($this->matchColumn!=null)
				$mc = $this->matchColumn;
			else
				$mc = self::$table.'id';
		return $mc;
	}

}


?>