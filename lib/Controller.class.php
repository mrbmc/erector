<?php

class Controller {

	public $title = "Home";
	public $view = "index";
	public $redirect;
	public $user;
	public $xml;
	public $data;

	function __construct($_title=null,$_view=null)
	{
		$this->title = ($_title) ? $_title : ($_REQUEST['action'] ? $_REQUEST['action'] : $this->title);
		$this->view = ($_view) ? $_view : (Dispatcher::instance()->controller!="" ? strtolower(Dispatcher::instance()->controller) : $this->view);
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
