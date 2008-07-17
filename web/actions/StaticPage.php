<?php

class StaticPage extends Action {

	function __construct () {
		global $DISPATCH;
		parent::__construct("StaticPage");
		$this->template = file_exists("templates/" . $DISPATCH->action . ".tpl") ? $DISPATCH->action . ".tpl" : "errors/404.tpl";
		$this->title = file_exists("templates/" . $DISPATCH->action . ".tpl") ? $DISPATCH->action : "404 Error: \"" . $DISPATCH->action. "\" Not Found";
	}
}

?>