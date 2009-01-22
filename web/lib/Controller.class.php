<?php

class Controller {

	public $title;
	public $view;
	public $format = "html";
	public $redirect;
	public $user;
	public $session;

	private $dispatch;
	private $config;

	function __construct($_title = "home")
	{
		global $CONFIG;
		$this->dispatch = Dispatcher::singleton();

		$this->title = ($_title!="") ? $_title : $_REQUEST['act'];
		$this->session = Session::singleton();
		$this->user = new User(array('id'=>$this->session->get('userid')));

		$this->view = strtolower($this->dispatch->controller);
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