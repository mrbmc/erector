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
				echo "REGISTERING";
//				$this->user->setFrom($_POST);
//				$this->user->save();
//				$this->session->set('feedback','Thank you for registering');
//				$this->user = new User();
				$this->redirect = "/";
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