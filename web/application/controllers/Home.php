<?php

class Home extends Controller {

	function __construct () {
		parent::__construct("Home");
		unset($_SESSION['feedback']);
	}
}

?>