<?php

class Login extends Action {

	function __construct () {
		parent::__construct("Login");
		$this->user = new User(array('user_username'=>$_REQUEST['username'],'user_password'=>$_REQUEST['password']));
		$this->session->set('user_id',$this->user->user_id);
		$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
	}

}

?>