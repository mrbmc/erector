<?php

class Dispatcher
{
	private $className;
	private $classFile;
	public $action = "Home";
	public $id;
	private $params = array();

	function __construct() {
		$this->parseURL();
	}

	public function toArray()
	{
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

	private function validateClass () {

		if(!file_exists("actions/" . $this->className . ".php"))
			$this->className = "StaticPage";

		include_once "actions/" . $this->className . ".php";

		if(!class_exists($this->className) || get_parent_class($this->className)=="Model")
		{
			$this->className = "StaticPage";
			include_once "actions/" . $this->className . ".php";
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
	}


	public function go () {
		$classname = $this->validateClass();
		return new $classname();
	}
}

?>