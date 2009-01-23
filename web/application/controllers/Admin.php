<?php

class Admin extends Controller {

	public $briefs;
	public $users;
	public $pitches;
	private $id;

	function __construct () {
		global $DISPATCH;
		parent::__construct("Admin");
		$this->title = "Admin area";
		$this->view = 'admin/admin.tpl';
		$this->id = $DISPATCH->id;
		
		echo $DISPATCH->action;
		if($_GET['do']!=""){
			eval($this->$_GET['do']());
		}

		if($this->format == "xls")
			$this->view = $this->$_GET['do'];
	
	}


	private function users () {
		if($_POST['do']=="save")
		{
			$u = new Users();
			$u->setFrom($_POST);
			$u->save();
		}
		if($_POST['do']=="delete")
		{
			$u = new Users();
			$u->setFrom($_POST);
			if($u->delete()) {
				$this->redirect = "./";
			}
		}

		if($this->id>0) {
			$this->users = new Users(array('userid'=>$this->id));
			$SQL = "SELECT pitches.*" .
					", briefs.title AS brieftitle, briefs.client " .
					", users.username " .
					"FROM pitches " .
					"LEFT JOIN briefs ON briefs.briefid = pitches.briefid " .
					"LEFT JOIN users ON user.id = pitches.userid " .
					"WHERE pitches.userid = '".$this->id."'";
			$this->pitches = Pitches::load($SQL);
		}
		else
			$this->users = Users::load();
			
			
	}


	private function subscribed(){
		$SQL = "SELECT users.email FROM users WHERE users.subscription= 'true'AND users.status  = 'active' ";
		$subscribed=array();
		$subscribed= Users::load($SQL);
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment;  filename="subscribed_users.txt"'); 
	
		foreach($subscribed as $value)
			echo $value['email']. ", \n";
		exit;
			
	}
		
	
	
	
	private function pitches() {
		if(isset($_POST['do'])) {
			$u = new Pitches();
			$u->setFrom($_POST);

			switch($_POST['do'])
			{
			case "save":
				$u->save();
			break;
			case "delete":
				if($u->delete())
					$this->redirect = "./";
			break;
			}
		}



		if($this->id>0) {
			$this->pitches = new Pitches(array('pitchid'=>$this->id));
		}
		else {
			$SQL = "SELECT pitches.*" .
					", briefs.title AS brieftitle, briefs.client " .
					", users.username " .
					"FROM pitches " .
					"LEFT JOIN briefs ON briefs.briefid = pitches.briefid " .
					"LEFT JOIN users ON users.userid = pitches.userid ";
			$this->pitches = Pitches::load($SQL);
		}
	}

	private function briefs () {
		if($_POST['do']=="save")
		{
			$obj = new Briefs();
			$obj->save();
			$this->id = $obj->briefid;
			$imgpath = getcwd() . "/images/assignments/" . $this->id;
			if(!is_dir($imgpath))
				mkdir($imgpath);

			if (!empty($_FILES['logofile']['tmp_name']))
				move_uploaded_file( $_FILES['logofile']['tmp_name'] , $imgpath . "/logo.gif");

			if (!empty($_FILES['bannerfile']['tmp_name']))
				move_uploaded_file( $_FILES['bannerfile']['tmp_name'] , $imgpath . "/banner.jpg");

			if (!empty($_FILES['sidebarfile']['tmp_name']))
				move_uploaded_file( $_FILES['sidebarfile']['tmp_name'] , $imgpath . "/sidebar.jpg");
	
		}

		// DETAIL PAGE
		if($this->id!="") {
			$this->briefs = new Briefs(array('briefid'=>$this->id));
			$SQL = "SELECT pitches.*" .
					", briefs.title AS brieftitle, briefs.client " .
					", users.username " .
					"FROM pitches " .
					"LEFT JOIN briefs ON briefs.briefid = pitches.briefid " .
					"LEFT JOIN users ON users.userid = pitches.userid " .
					"WHERE pitches.briefid = '".$this->briefs->briefid."' ";
			$this->pitches = Pitches::load($SQL);
		}
		// LISTINGS PAGE
		else
			$this->briefs = Briefs::load();
	}



}


?>