<?php

class Profile extends Controller {

	function __construct () {
		global $DISPATCH;
		parent::__construct("Profile");

		if(isset($DISPATCH->action)) {
			$this->user->setFrom($_POST);

			switch($DISPATCH->action)
			{
			case "update":
				if($_REQUEST['password_old'] == $this->user->password)
					$this->user->password = $_POST['password_new'];
				$this->user->save();
				$this->redirect = "/profile";
			break;
			case "create":
				$u = new User(array("username"=>$_POST['username']));
				if($u->id > 0) {
					$this->session->set('feedback','Thank you for registering. An email has been sent to you with details on activating your account.');
					$this->redirect = "/signup";
				}

				$this->user->setFrom($_POST);
				$this->user->confirmation = substr(md5(uniqid(rand())),0,10);
				$this->user->save();
				
				$this->format = "email";
				$this->template = "emails/signup.tpl";
				$this->EMAIL_LIST = array($this->user->email);
				//$this->session->set('feedback','Thank you for registering. An email has been sent to you with details on activating your account.');
				$this->user = new User();
				$this->redirect = "/";
			break;
			case "confirm":
				$this->user = new User(array("confirmation"=>$_GET['code']));
				if($this->user->id > 0)
				{
					$this->user->status="member";
					$this->session->set("userstatus",$this->user->status);
					$this->user->save();
					$this->redirect = $_REQUEST['referrer'] ? $_REQUEST['referrer'] : "/";
				}
			break;
			case "unique_username":
				$u = new User(array("username"=>$_GET['username']));
				echo ($u->id <= 0) ? "true" : "false";
				exit;
			break;
			case "unique_email":
				$u = new User(array("email"=>$_GET['email']));
				echo ($u->id <= 0) ? "true" : "false";
				exit;
			break;
			case "captcha":
				echo ($_GET['captcha']==$_SESSION['captcha_code']) ? "true" : "false";
				exit;
			break;
			case "validate_pw":
				echo ($_REQUEST['password_old'] == $this->user->password) ? "true" : "false";
				exit;
			break;
			case "pw_reminder":
			break;
			}
		}


	}
}

?>