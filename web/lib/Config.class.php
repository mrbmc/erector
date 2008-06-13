<?php
class Config
{

	/**
	 *	SITE CONFIGURATION
	 */
	var $DOCROOT = '';
	var $EMAIL_NAME = "Edelman Studios";
	var $EMAIL_ADDRESS = "info@edelmanstudios.com";
	var $UPLOADS = "/uploads";

	/**
	 * DATABASE CREDENTIALS
	 */
	var $dsn = array(
		'type' => "mysql",
		'host' => "localhost",
		'db' => "template",
		'user' => "template",
		'pass' => "EIS315"
	);


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
