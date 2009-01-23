<?php
class Config
{

	/**
	 *	SITE CONFIGURATION
	 */
	var $DOCROOT = '';
	var $EMAIL_NAME = "Erector";
	var $EMAIL_ADDRESS = "admin@kageki.com";
	var $UPLOADS = "/uploads";
	var $ENV_STAGING = "LOCALHOST";
	var $ENV_PRODUCTION = "";

	/**
	 * DATABASE CREDENTIALS
	 */
	//PRODUCTION
	private $dsn_production = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "",
		'user' => "",
		'pass' => ""
	);
	//STAGING
	private $dsn_staging = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "erectordb",
		'user' => "erector",
		'pass' => "asdzxc"
	);
	public function dsn () {
		return (stristr($_SERVER["HTTP_HOST"],$this->ENV_STAGING)!==FALSE) ? $this->dsn_staging : $this->dsn_production;
	}


	/**
	 * FACEBOOK
	 */
	var $fb_apikey = '';
	var $fb_apisecret = '';


	/**
	 *	STYLECONFIGURATION
	 */
	var $DATEFORMAT = "M.d.Y";
	var $timezone = "America/New_York";
	var $perPage = 10;



	private function __construct() {
		$this->DOCROOT = 'http://' . $_SERVER['HTTP_HOST'] . $this->DOCROOT;
		date_default_timezone_set($this->timezone);
		$this->UPLOADS = getcwd() . $this->UPLOADS;
	}

	private static $_instance;
	public static function instance () {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname;
		}
		return self::$_instance;
	}

}
?>
