<?php

class Controller {

	public $title;
	public $view;
	public $redirect;
	public $user;
	public $xml;

	function __construct($_title = "home")
	{
		$this->title = ($_title!="") ? $_title : $_REQUEST['action'];
		$this->view = strtolower(Dispatcher::instance()->controller);
		$this->user = new User(array('userid' => Session::instance()->get('userid')));
		$this->action(Dispatcher::instance()->action);
	}

	protected function action ($_action=null) {
		//Debugger::trace("action",$_action);
		if(method_exists($this,$_action)){
			$this->$_action();
		} else if($_action!=null) {
			$this->view = "errors/404";
		} else if(method_exists($this,"index")) {
			$this->index();
		}
	}

}
 

?>
