<?php

class Dispatcher
{
	private $className;
	private $classFile;
	public $controller;
	public $action;
	public $id;
	private $params;

	function __construct() {
		$this->controller = "Home";
		$this->params = array();
		$this->parseURL();
	}

	private function validateClass () {

		if(file_exists(LIB."/controllers/" . $this->className . ".php"))
			include_once (LIB."/controllers/" . $this->className . ".php");
		else
			include_once LIB."/Controller.class.php";

		if(!class_exists($this->className) || get_parent_class($this->className)=="Model")
			$this->className = "Controller";

		return $this->className;
	}


	private function parseURL () {
		$this->params = split("/",$_SERVER['REQUEST_URI']);

		if($this->params[1] == "admin"){
			$this->controller = $this->params[2];
			$this->className = "Admin";
			$this->id = $this->params[3];
		} else {
			if($this->params[1]!="")
				$this->controller = ucfirst(strtolower($this->params[1]));
			$this->className = $this->controller;

			if(!is_numeric($this->params[2]))
				$this->action = $this->params[2];
			else
				$this->id = $this->params[2];

			if(is_numeric($this->params[3]) && $this->params[3]!=$this->id)
				$this->id = $this->params[3];

		}


		// Override the dispatcher URL structure with params
		if($_GET['controller']!="")
			$this->controller = trim($_GET['controller']);
		if($_GET['do']!="")
			$this->action = trim($_GET['do']);
		if($_GET['id']!="")
			$this->id = trim($_GET['id']);
	}


	public function go () {
		$classname = $this->validateClass();
		return new $classname();
	}
}

?>