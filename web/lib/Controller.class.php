<?php

class Controller {

	public $title;
	public $view;
	public $format = "html";
	public $redirect;
	public $user;
	public $session;

	function __construct($_title = "home")
	{
		$this->title = ($_title!="") ? $_title : $_REQUEST['act'];
		$this->session = Session::singleton();
		$this->user = new User(array('id'=>$this->session->get('userid')));
		$this->view = strtolower(Dispatcher::instance()->controller);
	}

	protected function action () {
		$method = Dispatcher::instance()->action;
		//Debugger::trace("method",$method);
		if(method_exists($this,$method)){
			$this->$method();
		} else if($method) {
			$this->view = "errors/404";
		} else if(method_exists($this,"index")) {
			$this->index();
		}
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


}
 

?>