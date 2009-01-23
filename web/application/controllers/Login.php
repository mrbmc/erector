<?php

class Login extends Controller {

	function __construct () {
		global $DISPATCH;
		parent::__construct("Login");

		if($_POST['do']=="logout")
			$this->logout();
		else
			$this->login();

		$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
	}

	protected function login () {
		$this->user = new User(array('username'=>$_REQUEST['username'],'password'=>$_REQUEST['password']));
		Session::instance()->set('userstatus',$this->user->status);
		if($this->user->status!='pending')
			Session::instance()->set('userid',$this->user->id);
	}

	protected function logout () {
		$this->user = new User();
		Session::instance()->set('userid',0);
		Session::instance()->set('userstatus',$this->user->status);
	}

}

?>