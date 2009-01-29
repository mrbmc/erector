<?php

include_once LIB.'/db/SimpleDB.class.php';			//DB persistence

abstract class Model {

	protected $sql;
	protected static $db;
	protected static $table;

	function __construct($args=null)
	{
		self::$db = new SimpleDB(Config::instance()->dsn());
		self::$table = strtolower(get_class($this));

		if(is_array($args)) {
			$sql = "SELECT * FROM ".self::$table." WHERE 1 ";
			foreach($args as $k=>$v)
				$sql .= "AND ".$k." LIKE '".$v."' ";
			self::set(self::$db->query_first($sql));
		}
	}

	public static function load ($sql_extra=null) {
		$return = array();
		$sql = (stristr($sql_extra,"SELECT")!==false) ? $sql_extra : "SELECT * FROM ".self::$table." ".$sql_extra;
		$result = self::$db->query($sql);
		while($row = self::$db->fetch_array($result))
		{
			$classname = ucfirst(self::$table);
			$obj = new $classname();
			$obj->set($row);
			array_push($return, $obj);
		}
		return $return;
	}


	public function save ($_matchcolumn='id',$_data=null) {
		$this->sql = self::$db->build_sql(self::$table,$_matchcolumn,$_data);
		$saved = self::$db->query($this->sql); 
		if(stristr($this->sql,"INSERT")!==false && $saved==true)
			$this->id = self::$db->insert_id();
		return $saved;
	}


	public function delete ($matchcolumn,$id) {
		$this->sql = "DELETE FROM ".self::$table." WHERE $matchcolumn = '$id'";
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