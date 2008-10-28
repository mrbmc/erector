<?php

class Dispatcher
{
	private $className;
	private $classFile;
	public $action;
	public $id;
	private $params;

	function __construct() {
		$this->action = "Home";
		$this->params = array();
		$this->parseURL();
	}

	private function validateClass () {

		if(!file_exists(LIB."/actions/" . $this->className . ".php"))
			$this->className = "StaticPage";

		include_once LIB."/actions/" . $this->className . ".php";

		if(!class_exists($this->className) || get_parent_class($this->className)=="Model")
		{
			$this->className = "StaticPage";
			include_once LIB."/actions/" . $this->className . ".php";
		}

		return $this->className;
	}


	private function parseURL () {
		$this->params = split("/",$_SERVER['REQUEST_URI']);

		if($this->params[1] == "admin"){
			$this->action = $this->params[2];
			$this->className = "Admin";
			$this->id = $this->params[3];
		} else {
			if($this->params[1]!="")
				$this->action = ucfirst(strtolower($this->params[1]));
			$this->className = $this->action;
			$this->id = $this->params[2];
		}


		// This allows you to override the dispatcher using URL params
		if($_GET['action']!="") {
			$this->action = trim($_GET['action']);
		}
		if($_GET['id']!="") {
			$this->id = trim($_GET['id']);
		}
	}


	public function go () {
		$classname = $this->validateClass();
		return new $classname();
	}
}

?>