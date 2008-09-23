<?php
class Config
{

	/**
	 *	SITE CONFIGURATION
	 */
	var $DOCROOT = '';
	var $EMAIL_NAME = "";
	var $EMAIL_ADDRESS = "";
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
		'pass' => "EIS215"
	);
	public function dsn () {
		return (stristr($_SERVER["HTTP_HOST"],$this->ENV_STAGING)!==FALSE) ? $this->dsn_staging : $this->dsn_production;
	}


	/**
	 * FACBEOOK
	 */
	var $fb_apikey = '';
	var $fb_apisecret = '';


	/**
	 *	STYLECONFIGURATION
	 */
	var $DATEFORMAT = "M.d.Y";
	var $timezone = "America/New_York";
	var $perPage = 10;


	/**
	 * Constructor
	 */
	function __construct() {
		$this->DOCROOT = 'http://' . $_SERVER['HTTP_HOST'] . $this->DOCROOT;
		date_default_timezone_set($this->timezone);
		$this->UPLOADS = getcwd() . $this->UPLOADS;
	}

}
?>
