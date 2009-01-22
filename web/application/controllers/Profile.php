<?php

class Profile extends Controller {

	function __construct () {
		global $DISPATCH;
		parent::__construct("Profile");

		if(isset($DISPATCH->action)) {
			$method = $DISPATCH->action;
			$this->$method();
		}
	}

	private function update () {
		$this->user->setFrom($_POST);
		if($_REQUEST['password_old'] == $this->user->password)
			$this->user->password = $_POST['password_new'];
		$this->user->save();
		$this->redirect = "/profile";
	}

	private function create () {
		$this->user->setFrom($_POST);
		$this->user->confirmation = substr(md5(uniqid(rand())),0,10);
		$this->user->save();
		if($this->user->id > 0) {
			$this->session->set('feedback','Thank you for registering. An email has been sent to you with details on activating your account.');
			$this->format = "email";
			$this->view = "emails/signup.tpl";
			$this->EMAIL_LIST = array($this->user->email);
			$this->user = new User();
			$this->redirect = "/";
		} else {
			$this->session->set('feedback','An error occured creating your account.');
			$this->redirect = "/signup";
		}

	}
	private function confirm () {
		$this->user = new User(array("confirmation"=>$_GET['code']));
		if($this->user->id > 0)
		{
			$this->user->status="member";
			$this->user->save();
			$this->session->set("userstatus",$this->user->status);
			$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
		}
	}

	private function username_exists () {
		$u = new User(array("username"=>$_GET['username']));
		echo ($u->id > 0) ? "true" : "false";
		exit;
	}
	private function username_unique () {
		$u = new User(array("username"=>$_GET['username']));
		echo ($u->id <= 0) ? "true" : "false";
		exit;
	}
	private function email_exists () {
		$u = new User(array("email"=>$_GET['email']));
		echo ($u->id > 0) ? "true" : "false";
		exit;
	}
	private function email_unique () {
		$u = new User(array("email"=>$_GET['email']));
		echo ($u->id <= 0) ? "true" : "false";
		exit;
	}
	private function captcha () {
		echo ($_GET['captcha']==$_SESSION['captcha_code']) ? "true" : "false";
		exit;
	}
	private function validate_pw () {
		echo ($_REQUEST['password_old'] == $this->user->password) ? "true" : "false";
		exit;
	}
	private function pw_reminder () {
		$this->view = 'pw_reminder';
	}
	private function send_pw() {

		if($_POST['username'])
			$this->user = new User(array("username"=>$_POST['username']));
		else if($_POST['email'])
			$this->user = new User(array("email"=>$_POST['email']));

		if($this->user->id>0)
		{
			$this->EMAIL_LIST = array($this->user->email);
			$this->view = 'emails/pw_reminder';
			$this->format = "email";
			$this->redirect = "/";
		} else 
			$this->redirect = "/profile/pw_reminder";
	}
}

?>