<?php

include_once LIB.'/db/SimpleDB.class.php';			//DB persistence

abstract class Model {

	protected $sql;
	protected static $db;
	protected static $table;
	protected $matchColumn;

	function __construct($args=null)
	{
		self::$db = new SimpleDB(Config::instance()->dsn());
		self::$table = strtolower(get_class($this));
		$this->matchColumn = self::$table.'id';

		if($args!=null) {
			$this->set(self::load($args));
		}
	}

	private function getMatchColumn ($mc) {
		if($mc==null)
			if($this->matchColumn!=null)
				$mc = $this->matchColumn;
			else
				$mc = self::$table.'id';
		return $mc;
	}

	public static function load ($args=null) {

		// construct the SQL
		if(is_numeric($args)) {
			$sql_extra = "AND ".$this->getMatchColumn()."=".intval($args);
		} elseif(is_string($args)) {
			$sql_extra = $args;
		} else if(is_array($args)) {
			foreach($args as $k=>$v)
				if(property_exists(self,$k))
					$sql_extra .= "AND ".$k." LIKE '".$v."' ";
		}
		$sql = (stristr($sql_extra,"SELECT")!==false) ? $sql_extra : "SELECT * FROM ".self::$table." WHERE 1 ".$sql_extra;

		// make the query
		$results = self::$db->query($sql);

		//Parse the results
		$return = array();
		while($row = self::$db->fetch_array($results))
		{
			$classname = ucfirst(self::$table);
			$obj = new $classname();
			$obj->set($row);
			array_push($return, $obj);
		}
		return count($return>1)?$return:$return[0];
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

}


?>