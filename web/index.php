<?php
/**
 * DEBUGGING AND ERROR REPORTING
 */
define("DEBUG",true);
ini_set('display_errors', DEBUG);
ini_set('error_reporting', (DEBUG ? (E_ERROR | E_WARNING | E_PARSE ) : E_ERROR));

/**
 * 
 * Initialize configuration and load the codebase
 * 
 */
include_once getcwd().'/../application/Config.class.php';				//Settings and configuration
Config::instance();

/**
 * 
 * MODEL
 * 
 * Auto load the data models as they're needed 
 * 
 * By convention models are named in singular
 * i.e. User
 * 
 */
function __autoload($class_name) {
	$file = APP."/models/" . $class_name . '.model.php';
	if (file_exists($file) == false)
    	return false;
    include_once $file;
}

/**
 * 
 * CONTROLLER
 * 
 * Load the appropriate controller class based on 
 * the URL. 
 * 
 * Will also look for views if no controller is 
 * available. This allows you to create static pages with no
 * controller. Not that you should... but you could.
 * 
 * By convention the controllers are named in plural:
 * i.e. Users
 * 
 */
Dispatcher::instance()->dispatch();

/**
 * 
 * VIEW
 * 
 * The Presenter class takes the data from the Controller
 * and generates the appropriate output. This allows 
 * full model / view separation.
 *  
 */
Presenter::instance()->present();

exit();
?>
