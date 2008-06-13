<?php

class Session 
{
	private static $instance;
	public static $sessionID;

	private function __construct()
	{
		session_start();
		self::$sessionID = session_id();
	}

	public static function singleton () {
		if (!isset(self::$instance)) {
			$className = __CLASS__;
			self::$instance = new $className;
		}
		return self::$instance;
	}

	public function destroy ()
	{
		foreach ($_SESSION as $var => $val)
			$_SESSION[$var] = null;
		session_destroy();
	}

	public function __clone() {
		trigger_error('Clone is not allowed for '.__CLASS__,E_USER_ERROR);
	}

	public function get($var) {
		return isset($_SESSION[$var]) ? $_SESSION[$var] : false;
	}

	public function set($var,$val) {
		return ($_SESSION[$var] = $val);
	}

}

?>