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
		$this->user = new User(
			array(
				'username'=>sql_sanitize($_REQUEST['username']),
				'password'=>md5(sql_sanitize($_REQUEST['password']))
			)
		);
//		Debugger::trace('user',$this->user,true);
		Session::instance()->set('userstatus',$this->user->status);
		if($this->user->status!='pending')
			Session::instance()->set('userid',$this->user->userid);
//		Debugger::trace('session',$_SESSION,true);
	}

	protected function logout () {
		$this->user = new User();
		Session::instance()->set('userid',0);
		Session::instance()->set('userstatus',$this->user->status);
	}

}

?>