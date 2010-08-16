<?php

class Debugger {
	private static $instance;
	public static $console;
	private $benchmarks;

    private function __construct() {
    }
    
    public static function getInstance () {
 		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
    }

	public static function trace() {
		if(!DEBUG)
			return;
		$key = null;
		$val = null;
		$args = func_get_args();
		if(count($args)>1) {
			$key = $args[0];
			$val = $args[1];
		} else {
			$val = $args[0];
		}
		$return = "";
		if(gettype($val)=="array" || gettype($val)=="object")
		{
			if($key) $return .= $key . ":<br />";
			$return .= '<pre>';
			$return .= print_r($val,true);
			$return .= "</pre>";
		} else {
			if($key) $return .= $key . ": ";
			$return .= $val;
		}
		$return .= "<br />";
		if(array_pop($args)===true)
			echo $return;
		else
			Debugger::$console .= $return;
	}
}
?>