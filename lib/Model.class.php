<?php

abstract class Model {

	protected $sql;
	protected static $db;
	public static $table;
	protected $matchColumn;
	public $num_rows;
	public $xml;
	public $json;

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

	public static function getCount () {
		$args = func_get_args();
		$args = $args[0];
		$where = (isset($args['where'])) ? $args['where'] : $args;
		if(is_numeric($where)) {
			$_where = "AND ".$this->getMatchColumn()."=".intval($where);
		} elseif(is_string($where)) {
			$_where = $where;
		} elseif(is_array($where)) {
				foreach($where as $k=>$v)
					$_where .= "AND ".$k." LIKE '".$v."' ";
		}
		$sql = "SELECT count(*) FROM ".self::$table." WHERE 1 ".$_where;
		$results = Config::instance()->db->query_first($sql);
		return $results['count(*)'];
	}

	/**
	 * @name load
	 * @param mixed args a string, integer, or array of parameters to create SQL
	 * @return array an array populated with Objects for the data found
	 */
	public static function load () {
		$args = func_get_args();
		$args = $args[0];

		if(is_array($args)) {
			$where = isset($args['where']) ? $args['where'] : $args;
			if($args['select']) $_select .= ",".(is_array($args['select'])?implode(","):$args['select']);
			if($args['order']) $_order .= " ORDER BY ".$args['order'];
			if($args['limit']) $_limit .= " LIMIT ".$args['limit'];
		} else
			$where = $args;

		if(is_numeric($where)) {
			$_where = "AND ".(self::$table.'id')."=".intval($where);
		} elseif(is_string($where)) {
			$_where = $where;
		} elseif(is_array($where) && count($where)>0) {
				foreach($where as $k=>$v)
					if($k!='select' && $k!='order' && $k!='limit')
						$_where .= "AND ".$k." LIKE '".$v."' ";
		}
/*
		$where = (is_array($args) && isset($args['where'])) ? $args['where'] : $args;
		if(is_numeric($where)) {
			$_where = "AND ".(self::$table.'id')."=".intval($where);
		} elseif(is_string($where)) {
			$_where = $where;
		} elseif(is_array($where)) {
				foreach($where as $k=>$v)
					$_where .= "AND ".$k." LIKE '".$v."' ";
		}
		if($args['select']) $_select .= ",".(is_array($args['select'])?implode(","):$args['select']);
		if($args['order']) $_order .= " ORDER BY ".$args['order'];
		if($args['limit']) $_limit .= " LIMIT ".$args['limit'];
*/

		$sql = (stristr($args[0],"SELECT")!==false) ? $args[0] : "SELECT *".$_select." FROM ".self::$table." WHERE 1 ".$_where.$_order.$_limit;
//		Debugger::trace('sql',$sql,true);
		// make the query
		$results = Config::instance()->db->query($sql);
		//Parse the results
		$return = array();
		while($row = Config::instance()->db->fetch_array($results))
		{
			$classname = ucfirst(self::$table);
			$obj = new $classname();
			$obj->set($row);
			array_push($return, $obj);
		}
//		Debugger::trace('results',$return,true);
		return $return;
	}


	public function save ($_matchcolumn=null,$_data=null) {
		$matchcolumn = ($_matchcolumn==null) ? $this->matchcolumn : $_matchcolumn;
		if($_data==null)
			$_data = (array)$this;
		$class = get_class($this);
//		Debugger::trace('sql',$this->sql,true);
		$this->sql = self::$db->build_sql(self::$table,$matchcolumn,$_data);
		$saved = self::$db->query($this->sql);
		if(stristr($this->sql,"INSERT")!==false && $saved==true)
			$this->$matchcolumn = self::$db->insert_id($db);
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