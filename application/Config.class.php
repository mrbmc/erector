<?php
class Config
{

	/**
	 *	SITE CONFIGURATION
	 */
	public $SITE_NAME = "Erector!";
	private static $ENV_PRODUCTION = "www.yourdomain.com";
	private static $ENV_STAGE = "";
	private static $ENV_DEV = "localhost";
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
		'user' => "root",
		'pass' => "root"
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
	const PERPAGE = 20;


	const GOOGLE_MAPS_KEY = "";

	/**
	 * FACEBOOK
	 */
	const FB_APPID = '';
	const FB_APIKEY = '';
	const FB_APISECRET = '';

	/**
	 * TWITTER
	 */
	const TWITTER_APIKEY = '';
	const TWITTER_APISECRET = '';

	/**
	 * Amazon Web Services
	 */
	const AWS_ID = ""; 
	const AWS_SECRET = "";


/**
 * ----------------------------------------------------------------------
 * NO NEED TO EDIT BELOW HERE
 * ----------------------------------------------------------------------
 */
	public $db;

	private function __construct() {
		define('LIB',getcwd() . "/../lib");
		define('WEBROOT',getcwd() . "");
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

		// Establish the Database connection once
		$env = "dsn_".strtolower(self::getEnvironment());
		$dsn =& $this->$env;
		$class = 'ErectorDB_'.$dsn['type'];
		include_once LIB.'/db/'.$class.'.class.php';


		try {
			if(class_exists($class))
				$this->db = new $class($dsn);
			else
				throw new Exception("The db class ".$class." could not be created");
		} catch (Exception $e) {
			echo $e->getMessage()."\n";
		}
	}

	private static $_instance;
	public static function instance () {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname;
		}
		return self::$_instance;
	}

	public function getDSN($env=null) {
		$dsn_name = "dsn_".($env ? $env : strtolower($this->getEnvironment()));
		return $this->$dsn_name;
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
