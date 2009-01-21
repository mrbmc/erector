<?php

abstract class Action {

	public $title;
	public $template;
	public $format = "html";
	public $redirect;
	public $user;
	public $session;

	function __construct($_title = "home")
	{
		global $CONFIG;
		$this->title = ($_title!="") ? $_title : $_REQUEST['act'];
		$this->template = ($_title!="") ? strtolower($_title).".tpl" : strtolower($_REQUEST['act']) . ".tpl";
		$this->session = Session::singleton();
		$this->user = new User(array('user_id'=>$this->session->get('user_id')));
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