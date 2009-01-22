<?php

class Controller {

	public $title;
	public $template;
	public $format = "html";
	public $redirect;
	public $user;
	public $session;

	function __construct($_title = "home")
	{
		global $CONFIG,$DISPATCH;
		$this->title = ($_title!="") ? $_title : $_REQUEST['act'];
		$this->session = Session::singleton();
		$this->user = new User(array('id'=>$this->session->get('userid')));

		if(file_exists(LIB . "/views/" . strtolower($DISPATCH->controller) . ".tpl"))
			$this->template = strtolower($DISPATCH->controller) . ".tpl";
		else
			$this->template = "./errors/404.tpl";
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