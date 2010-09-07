<?php

class Controller {

	public $title = "Home";
	public $view = "index";
	public $format = "html";
	public $redirect;
	public $user;
	public $xml;
	public $data;

	function __construct($_title=null,$_view=null)
	{
		$this->user = Session::instance()->get('user');
		$this->title = ($_title) ? $_title : (Dispatcher::instance()->action ? Dispatcher::instance()->action : $this->title);
		$this->view = ($_view) ? $_view : (Dispatcher::instance()->controller!="" ? strtolower(Dispatcher::instance()->controller) : $this->view);
		$this->pagenav = new Paginate();
		//Debugger::trace("controller",$this,true);
	}

	public function setError($message,$persistent=false) {
		Session::instance()->set('feedback',nl2br($message));
	}
}
 

?>
