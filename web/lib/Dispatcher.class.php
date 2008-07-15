<?php

class Dispatcher
{
	//RewriteRule ^(\w*)\/*([\d\s\w]*)\/*\?*(.*)$						index.php?act=$1&id=$2&$3 [QSA]
	//RewriteRule ^admin\/*([\d\s\w]*)\/*\?*(.*)$						index.php?act=admin&do=$1&id=$2&$3 [L,QSA]
	public $className;
	public $id;

	function __construct() {
		$params = split("/",$_SERVER['REQUEST_URI']);
		$this->className = $params[1]!="" ? ucfirst(strtolower($params[1])) : "Home";
		$this->id = ($params[2]>0) ? $params[2] : 0;

		if($this->className=="Admin")
			$this->id = ($params[3]>0) ? $params[3] : 0;
	}

	public function go () {
		if(!file_exists("actions/" . $this->className . ".php"))
			$this->className = "StaticPage";
		include_once "actions/" . $this->className . ".php";
		return class_exists($this->className) ? new $this->className : false;
	}
}

?>