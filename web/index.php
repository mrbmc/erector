<?php


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * DEBUGGING AND ERROR REPORTING
 */
define("DEBUG",true); // This boolean controls many useful debugging functions
ini_set('display_errors', DEBUG);
ini_set('error_reporting', (DEBUG ? (E_ERROR | E_WARNING | E_PARSE ) : E_ERROR));
ini_set('include_path',ini_get('include_path').";".getcwd()."/lib/".";".getcwd()."/models/");


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Load some classes
 */
define('LIB',getcwd() . "/lib");
include_once LIB.'/Config.class.php';					//Settings and configuration
include_once LIB.'/Dispatcher.class.php';				//URL routing and control
include_once LIB.'/DB/SimpleDB.class.php';				//DB persistence
include_once LIB.'/Action.class.php';					//Page controller class
include_once LIB.'/Model.class.php';					//Parent data model class - ORM
include_once LIB.'/Session.class.php';					//Session management
include_once LIB.'/facebook/facebook.php';				//Facebook applications & pages
include_once LIB.'/Paginate.class.php';					//List pagination class


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Initialize configuration and settings
 */
$CONFIG = new Config();


/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * Load data models
 */
function __autoload($class_name) {
    include_once getcwd() . "/models/" . $class_name . '.class.php';
}

/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * 
 * CONTROLLER
 * 
 * Load the appropriate page action class based on 
 * the URL. Will look for templates if no action is 
 * available.
 * 
 * This allows for static pages to be added with no
 * action class. Not that you should... but you could.
 * 
 * TODO: replace with a dispatcher class that allows more
 * control over URL -> action mapping
 * 
 */
$dispatcher = new Dispatcher();
$ACTION = $dispatcher->go();

/**++++++++++++++++++++++++++++++++++++++++++++++++++
 * 
 * VIEW
 * 
 * The Presenter class takes the data from the Action
 * and generates the appropriate output. This allows 
 * full model / view separation.
 *  
 */
include_once LIB.'/Presenter.class.php';
$view = new Presenter();

exit();
?>