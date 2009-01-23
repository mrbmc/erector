<?php

class Dispatcher
{
	public $_controller;

	public $controller = "Home";
	public $action;
	public $id;

	private function __construct() {}

	private static $_instance;
	public static function instance () {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname;
		}
		return self::$_instance;
	}

	private function parseURL () {
		if($_SERVER["REQUEST_URI"]=="/")
			return;
		$args = split("/",$_SERVER['REDIRECT_URL']);
		for($i=1,$x=count($args);$i<$x;$i++)
		{
			if(is_numeric($args[$i]))
				$this->id = $args[$i];
			else if($i<=1)
				$this->controller = $args[$i];
			else if(!$this->action)
				$this->action = $args[$i];
		}

		// Override the neat URL structure with key=val pairs
		if(isset($_GET['controller']))
			$this->controller = trim($_GET['controller']);
		if(isset($_GET['do']))
			$this->action = trim($_GET['do']);
		if(isset($_GET['id']))
			$this->id = trim($_GET['id']);
	}

	private function validateClass () {

		if(file_exists(APP."/controllers/" . strtolower($this->controller) . ".php"))
			include_once (APP."/controllers/" . strtolower($this->controller) . ".php");
		else
			include_once LIB."/controller.class.php";

		if(!class_exists($this->controller) || get_parent_class($this->controller)=="Model")
			return "Controller";

		return $this->controller;
	}

	public function getController () {
		$this->parseURL();
		$c = $this->validateClass();
		return new $c();
	}
}

?>