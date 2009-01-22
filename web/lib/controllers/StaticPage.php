<?php

class StaticPage extends Controller {

	function __construct () {
		global $DISPATCH;
		parent::__construct("StaticPage");
		$this->template = file_exists(LIB."/views/" . strtolower($DISPATCH->controller) . ".tpl") ? strtolower($DISPATCH->controller) . ".tpl" : "errors/404.tpl";
	}
}

?>