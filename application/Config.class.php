<?php
class Config
{

	/**
	 *	SITE CONFIGURATION
	 */
	public $SITE_NAME = "Erector!";
	private static $ENV_PRODUCTION = "";
	private static $ENV_STAGE = "";
	private static $ENV_DEV = "localhost:8008";
	private $EMAIL_NAME = "Erector";
	private $EMAIL_ADDRESS = "no-reply@kageki.com";

	/**
	 * DATABASE CREDENTIALS
	 */
	//PRODUCTION
	private $dsn_production = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "erectordb",
		'user' => "erector",
		'pass' => "erector"
	);
	//STAGING
	private $dsn_stage = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "erectordb",
		'user' => "",
		'pass' => ""
	);
	//DEVELOPMENT
	private $dsn_dev = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "erectordb",
		'user' => "root",
		'pass' => "root"
	);

	/**
	 *	STYLECONFIGURATION
	 */
	const DATEFORMAT = "M.d.Y";
	const TIMEZONE = "America/New_York";
	const PERPAGE = 10;

	/**
	 * FACEBOOK
	 */
	const FB_APIKEY = '';
	const FB_APISECRET = '';

	/**
	 * Amazon Web Services
	 */
	const AWS_ID = "0BDYE6GJ8H4J5BRZD702"; 
	const AWS_SECRET = "YIj2f2dEL65oQmp4D5gDnAInJunDZ0UajQMxeasB";


/**
 * ----------------------------------------------------------------------
 * NO NEED TO EDIT BELOW HERE
 * ----------------------------------------------------------------------
 */

	private function __construct() {
		define('LIB',getcwd() . "/../lib");
		define('APP',getcwd() . "/../application");
		date_default_timezone_set(Config::TIMEZONE);

		include_once LIB.'/Erector.class.php';				//common functions and utilities
		include_once LIB.'/Model.class.php';				//Parent data model class - ORM
		include_once LIB.'/Controller.class.php';			//Page controller class
		include_once LIB.'/Dispatcher.class.php';			//URL routing and control
		include_once LIB.'/Presenter.class.php';			//View handler
		include_once LIB.'/Session.class.php';				//Session management
		include_once LIB.'/Paginate.class.php';				//List pagination class
		include_once LIB.'/Debugger.class.php';				//Debugging tools
		include_once LIB.'/facebook/facebook.php';			//Facebook applications & pages

	}
	private static $_instance;
	public static function instance () {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname;
		}
		return self::$_instance;
	}

	public static function dsn () {
		$env = "dsn_".strtolower(self::getEnvironment());
		return Config::instance()->$env;
	}

	private function getEnvironment () {
		switch($_SERVER["HTTP_HOST"]) 
		{
		case self::$ENV_DEV:
			return "DEV";
		break;
		case self::$ENV_STAGE:
			return "STAGE";
		break;
		default:
			return "PRODUCTION";
		break;
		}
	}

}
?>
