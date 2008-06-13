<?php

class StaticPage extends Action {

	function __construct () {
		parent::__construct("StaticPage");
		$this->template = file_exists("templates/" . $_REQUEST['act'] . ".tpl") ? $_REQUEST['act'] . ".tpl" : "errors/404.tpl";
		$this->title = $_REQUEST['act'];
	}

}

?>