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
		$this->user = new User(array('userid' => Session::instance()->get('userid')));
		$this->method = Dispatcher::instance()->action;
		$this->action($this->method);
	}

	protected function action ($_method=null) {
		//Debugger::trace("method",$method);
		if(method_exists($this,$_method)){
			$this->$_method();
		} else if($_method!=null) {
			$this->view = "errors/404";
		} else if(method_exists($this,"index")) {
			$this->index();
		}
	}

	public function index() {
	}

}
 

?>
