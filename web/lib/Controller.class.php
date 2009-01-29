<?php

class Controller {

	public $title;
	public $view;
	public $format = "html";
	public $redirect;
	public $user;
	public $xml;
	
	public $method;

	function __construct($_title = "home")
	{
		$this->title = ($_title!="") ? $_title : $_REQUEST['act'];
		$this->view = strtolower(Dispatcher::instance()->controller);
		$this->user = new User(array('id' => Session::instance()->get('userid')));

		$this->method = Dispatcher::instance()->action;
	}

	protected function action () {
		//Debugger::trace("method",$method);
		if(method_exists($this,$this->method)){
			$m = $this->method;
			$this->$m();
		} else if($this->method) {
			$this->view = "errors/404";
		} else if(method_exists($this,"index")) {
			$this->index();
		}
	}

}
 

?>
