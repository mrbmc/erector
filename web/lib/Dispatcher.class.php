<?php

//RewriteRule ^(\w*)\/*([\d\s\w]*)\/*\?*(.*)$						index.php?act=$1&id=$2&$3 [QSA]
//RewriteRule ^admin\/*([\d\s\w]*)\/*\?*(.*)$						index.php?act=admin&do=$1&id=$2&$3 [L,QSA]
class Dispatcher
{
	private $classFile;
	private $className;

	public $action;
	public $id;
	public $params;

	//private $keyvals = array('admin','id','action');

	function __construct() {
		$params = split("/",$_SERVER['REQUEST_URI']);
		$this->action  = $params[1]!="" ? ucfirst(strtolower($params[1])) : "Home";
		$this->id = ($params[2]>0) ? $params[2] : 0;
		$this->params = $params;

		$this->classFile = file_exists("actions/" . $this->action . ".php") ? $this->action : "StaticPage";
		$this->className = $this->classFile;
	}

	private function checkAdmin() {
		if($this->action != "Admin")
			return false;
		$this->classFile = "Admin";
		$this->action = $this->params[2];
		$this->id = $this->params[3];

		return true;
	}

	public function go () {
		$this->checkAdmin();
		if(file_exists("actions/" . $this->classFile . ".php"))
			include_once "actions/" . $this->classFile . ".php";
		if(class_exists($this->className))
			return new $this->className;
	}
}

?>