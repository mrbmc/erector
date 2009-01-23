<?php

abstract class Model {

	protected $sql;
	protected static $db;
	protected static $table;
	private $data = array();

	function __construct($args=null)
	{
		$this->s = Session::singleton();
		self::$db = new SimpleDB(Config::instance()->dsn());
		self::$table = strtolower(get_class($this));

		if($args!==null) {
			$sql = "WHERE 1 ";
			foreach($args as $k=>$v)
				$sql .= "AND ".$k."='".$v."' ";
			$_data = self::load($sql);
			if(isset($_data[0]))
				self::setFrom($_data[0]);
		}
	}

	public static function load ($sql_extra=null) {
		$return = array();
		$sql = (stristr($sql_extra,"SELECT")!==false) ? $sql_extra : "SELECT * FROM ".self::$table." ".$sql_extra;
		$result = self::$db->query($sql);
		while($row = self::$db->fetch_array($result))
		{
			array_push($return, $row);
		}
		return $return;
	}


	public function save ($_matchcolumn='id',$_data=null) {
		$this->sql = self::$db->build_sql(self::$table,$_matchcolumn,$_data);
		return self::$db->query($this->sql);
	}


	public function delete ($matchcolumn,$id) {
		$this->sql = "DELETE FROM ".self::$table." WHERE $matchcolumn = '$id'";
		return self::$db->query($this->sql);
	}


	public function __set($name, $value) {
		$this->data[$name] = $value;
	}

	public function __get($name) {
		if (array_key_exists($name, $this->data))
		    return $this->data[$name];
	
		$trace = debug_backtrace();
		trigger_error(
		'Undefined property: ' . $name .
		' in ' . $trace[0]['file'] .
		' on line ' . $trace[0]['line'],
		E_USER_NOTICE);
		return null;
	}



	public function setFrom ($data) {
		$valid = get_class_vars(get_class($this));
		if (is_array($data) && count($data))
			foreach ($valid as $var => $val) 
				if (isset($data[$var]))
					$this->$var = $data[$var];
		elseif (is_object($data))
			foreach ($valid as $var => $val) 
				if (isset($data->$var))
					$this->$var = $data->$var;
		return $this;
	}


	public function toArray()
	{
		//$defaults = $this->me->getDefaultProperties();
		$defaults = get_class_vars(get_class($this));
		$return = array();
		foreach ($defaults as $var => $val) 
		{
			if ($this->$var instanceof Model) {
				$return[$var] = $this->$var->toArray();
			} else {
				$return[$var] = $this->$var;
			}
		}
		return $return;
	}

}


?>