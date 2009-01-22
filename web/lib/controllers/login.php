<?php

class Login extends Controller {

	function __construct () {
		parent::__construct("Login");

		if($_POST['do']=="logout")
			$this->logout();
		else
			$this->login();

		$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
	}

	protected function login () {
		$this->user = new User(array('username'=>$_REQUEST['username'],'password'=>$_REQUEST['password']));

		if($this->user->status != 'pending')
			$this->session->set('userid',$this->user->id);
//			$this->session->set('feedback','You must confirm your account before you can log in. Check your email for your confirmation code.');
//		else
		$this->session->set('feedback',null);
	}

	protected function logout () {
		$this->user = new User();
		$this->session->set('userid',0);
	}

}

?>