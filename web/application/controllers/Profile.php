<?php

class Profile extends Controller {

	function __construct () {
		parent::__construct("Profile");
		$this->action();
	}

	protected function update () {
		if($this->user->id<=0)
		{
			$this->redirect = "/profile";
			return;
		}

		$this->user->setFrom($_POST);
		if($_REQUEST['password_old'] == $this->user->password)
			$this->user->password = $_POST['password_new'];
		$this->user->save();
		$this->redirect = "/profile";
	}

	protected function create () {
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
	protected function confirm () {
		$this->user = new User(array("confirmation"=>$_GET['code']));
		if($this->user->id > 0)
		{
			$this->user->status="member";
			$this->user->save();
			$this->session->set("userstatus",$this->user->status);
			$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
		}
	}

	protected function username_exists () {
		$u = new User(array("username"=>$_GET['username']));
		echo ($u->id > 0) ? "true" : "false";
		exit;
	}
	protected function username_unique () {
		$u = new User(array("username"=>$_GET['username']));
		echo ($u->id <= 0) ? "true" : "false";
		exit;
	}
	protected function email_exists () {
		$u = new User(array("email"=>$_GET['email']));
		echo ($u->id > 0) ? "true" : "false";
		exit;
	}
	protected function email_unique () {
		$u = new User(array("email"=>$_GET['email']));
		echo ($u->id <= 0) ? "true" : "false";
		exit;
	}
	protected function validate_pw () {
		echo ($_REQUEST['password_old'] == $this->user->password) ? "true" : "false";
		exit;
	}
	protected function pw_reminder () {
		$this->view = 'pw_reminder';
	}
	protected function send_pw() {

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