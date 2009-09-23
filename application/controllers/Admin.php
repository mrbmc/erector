<?php

class Admin extends Controller {

	public $users;
	public $hashtags;
	public $venues;
	private $id;

	function __construct () {
		parent::__construct("Admin");
		$this->title = "Admin area";
		$this->view = 'admin/admin.tpl';
		$this->id = Dispatcher::instance()->id;
		if($_GET['do']!=""){
			eval($this->$_GET['do']());
		}
	}


	public function users () {
		$u = new User();
		if($_POST['do']=="save")
		{
			$u->setFrom($_POST);
			$u->save();
		}
		if($_POST['do']=="delete")
		{
			$u->setFrom($_POST);
			if($u->delete()) {
				$this->redirect = "./";
			}
		}

		if($this->id>0) {
			$this->users = User::load(array('userid'=>$this->id));
		}
		else
			$this->users = User::load();
		$this->data =& $this->users;
			
	}

	
	protected function hashtags () {
		$obj = new Hashtag();
		if($_POST['do']=="save")
		{
			$obj->set($_POST);
			$obj->save();
		}
		if($this->id!="") {
			$this->hashtag = new Hashtag(array('hashtagid'=>$this->id));
		}
		else {
			$this->hashtags = Hashtag::load('ORDER BY date_added DESC');
		}
		
		$this->data =& $this->hashtags;
	}



}


?>