<?php

class Session 
{
	private static $_instance;
	public static $sessionID;

	private function __construct()
	{
		session_start();
		self::$sessionID = session_id();
//		if(!$this->get('userid'))
//		{
//			$this->set('userid',null);
//			$this->set('userstatus',null);
//		}
	}

	public static function instance () {

		if (!isset(self::$_instance)) {
			$className = __CLASS__;
			self::$_instance = new $className;
		}

		return self::$_instance;
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
