<?php

class Debugger {
	private static $instance;

    private function __construct() {
    }
    
    public static function getInstance () {
 		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
    }

	public function trace() {
		if(!DEBUG)
			return;

		$args = func_get_args();
		if(count($args)>1) {
			$key = $args[0];
			$val = $args[1];
		} else {
			$val = $args[0];
		}

		if(gettype($val)=="array" || gettype($val)=="object")
		{
			echo '<textarea cols="80" rows="10">';
			print_r($val);
			echo "</textarea>";
		} else {
			if($key) echo $key . "=";
			echo $val;
		}
		echo "<br />";
	}
}
?>