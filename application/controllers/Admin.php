<?php

class Admin extends Controller {

	public $users;
	public $hashtags;
	public $venues;
	private $id;

	function __construct () {
		$this->id = Dispatcher::instance()->id;
		if($_GET['do']!=""){
			eval($this->$_GET['do']());
		}
		$this->title = "Admin area";
		$this->view = 'admin/admin.tpl';
		parent::__construct($this->title,$this->view);
	}


	public function users () {
		$u = new User();
		if($_POST['do']=="save")
		{
			$u->set($_POST);
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

}


?>