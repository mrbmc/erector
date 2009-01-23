<?php


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * DEBUGGING AND ERROR REPORTING
 */
define("DEBUG",1); // This boolean controls many useful debugging functions
ini_set('display_errors', DEBUG);
ini_set('error_reporting', (DEBUG ? (E_ERROR | E_WARNING | E_PARSE ) : E_ERROR));
//ini_set('include_path',ini_get('include_path').";".getcwd()."/lib/");


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Load some classes
 */
define('LIB',getcwd() . "/lib");
define('APP',getcwd() . "/application");
include_once APP.'/Config.class.php';				//Settings and configuration
include_once LIB.'/Controller.class.php';			//Page controller class
include_once LIB.'/Model.class.php';				//Parent data model class - ORM
include_once LIB.'/Dispatcher.class.php';			//URL routing and control
include_once LIB.'/db/SimpleDB.class.php';			//DB persistence
include_once LIB.'/Session.class.php';				//Session management
include_once LIB.'/facebook/facebook.php';			//Facebook applications & pages
include_once LIB.'/Paginate.class.php';				//List pagination class
include_once LIB.'/Debugger.class.php';				//List pagination class
include_once LIB.'/Presenter.class.php';


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Initialize configuration and settings
 */
Config::instance();


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Load data models
 */
function __autoload($class_name) {
	$file = APP."/models/" . $class_name . '.model.php';
	if (file_exists($file) == false)
    	return false;
    include_once $file;
}


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * 
 * CONTROLLER
 * 
 * Load the appropriate controller class based on 
 * the URL. Will look for views if no controller is 
 * available.
 * 
 * This allows for static pages to be added with no
 * controller class. Not that you should... but you could.
 * 
 * TODO: replace with a dispatcher class that allows more
 * control over URL -> controller mapping
 * 
 */
Dispatcher::instance()->dispatch();


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * 
 * VIEW
 * 
 * The Presenter class takes the data from the Controller
 * and generates the appropriate output. This allows 
 * full model / view separation.
 *  
 */
$view = new Presenter();

exit();
?>