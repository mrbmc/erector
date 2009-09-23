<?php
/**
 * 
 * TODO: Augment dispatcher class with routing configuration.
 * allow fine graine control over URL -> controller mapping
 * 
 * */

class Dispatcher
{
	public $controllerInstance;

	public $controller = "index";
	public $action;
	public $id;
	public $format = 'html';

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

		if(stristr($_SERVER['REDIRECT_URL'],".")) {
			$tmp = explode(".",$_SERVER['REDIRECT_URL']);
			$url = $tmp[0];
			$format = $tmp[1];
		} else
			$url = $_SERVER['REDIRECT_URL'];

		$args = explode("/",$url);
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
		if(isset($_GET['action']))
			$this->action = trim($_GET['action']);
		if(isset($_GET['id']))
			$this->id = trim($_GET['id']);

		if(isset($format))
			$this->format = strtolower(trim($format));

	}

	private function validateClass () {
		if(file_exists(APP."/controllers/" . ucfirst(strtolower($this->controller)) . ".php"))
			include_once (APP."/controllers/" . ucfirst(strtolower($this->controller)) . ".php");
		else
			include_once LIB."/Controller.class.php";
		if(!class_exists($this->controller) || get_parent_class($this->controller)=="Model")
			return "Controller";
		return $this->controller;
	}

	public function dispatch () {
		$this->parseURL();
		$c = $this->validateClass();
		$this->controllerInstance = new $c();
		if($this->format)
			$this->controllerInstance->format = $this->format;
	}
}

?>
