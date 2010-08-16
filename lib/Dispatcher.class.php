<?php
/**
 * 
 * TODO: Augment dispatcher class with routing configuration.
 * allow fine graine control over URL -> controller mapping
 * 
 * */

class Dispatcher
{
	public $controllerInstance;

	public $controller = "Index";
	public $action = "index";
	public $view = "index";
	public $params;
	public $format = 'html';

	private function __construct() {}

	private static $_instance;
	public static function instance () {
		if (!isset(self::$_instance)) {
			$_classname = __CLASS__;
			self::$_instance = new $_classname;
		}
		return self::$_instance;
	}

	private function parseURL () {
		if($_SERVER["REQUEST_URI"]=="/")
			return;

		if(stristr($_SERVER['REDIRECT_URL'],".")) {
			$tmp = explode(".",$_SERVER['REDIRECT_URL']);
			$url = $tmp[0];
			$format = $tmp[1];
		} else
			$url = $_SERVER['REDIRECT_URL'];

/**
 * SMART URL PARSING
 * COMMON URL FORMATS
 * controller/
 * controller/action
 * controller/action/id
 * controller/id
 */
		$args = explode("/",$url);
		array_shift($args);
		$count = count($args);
		$this->controller = $this->validateController($args[0]);
		$this->action = $this->validateAction($args[1]);

		if($this->action==$args[1]) {
			$params = array_slice($args,2);
		} else {
			$params = array_slice($args,1);
		}
		if(count($params)>1)
			foreach($params as $k=>$v)
				$this->params[$k] = $v;
		else
			$this->params['id'] = $params[0];

		if($this->controller!=$args[0]) {
			$this->view = $args[0];
		}


		// Override the neat URL structure with key=val pairs
		if(isset($_GET['controller']))
			$this->controller = trim($_GET['controller']);
		if(isset($_GET['do']))
			$this->action = trim($_GET['do']);
		if(isset($_GET['action']))
			$this->action = trim($_GET['action']);
		if(isset($_GET['id']))
			$this->params['id'] = trim($_GET['id']);

		if(isset($format))
			$this->format = strtolower(trim($format));

	}

	private function validateController ($_class=null) {
		$class = ($_class!=null) ? $_class : $this->controller;
		$class = ucfirst(strtolower($class));
		if(file_exists(APP."/controllers/" . ucfirst(strtolower($class)) . ".php"))
			require_once (APP."/controllers/" . ucfirst(strtolower($class)) . ".php");
				if(class_exists($class) && get_parent_class($class)!="Model")
					return $class;
		require_once LIB."/Controller.class.php";
		return "Controller";
	}

	private function validateAction($_action=null) {
		$action = ($_action!=null)?$_action:$this->action;
		$controllerClass = $this->validateController(null);
		if(method_exists($controllerClass,$action))
			return $action;
		else if(method_exists($controllerClass,"index"))
			return "index";
		else
			return false;
	}

	private function executeController ($_controller=null) {
		$controller = $this->validateController($_controller);
		$path = ($this->controller=="Controller")?(LIB . "/Controller.class.php"):(APP."/controllers/" . $this->controller . ".php");
		include_once ($path);
		$this->controllerInstance = new $controller();
	}

	private function executeAction ($_action=null) {
		$action = $this->validateAction($_action);
		if($action)
			$this->controllerInstance->$action();
		else
			$this->controllerInstance->view = $this->view;
	}

	public function dispatch () {
		$this->parseURL();
		$this->executeController();
		$this->executeAction();
		if($this->format)
			$this->controllerInstance->format = $this->format;

		//Debugger::trace('dispatcher',Dispatcher::instance(),true);
	}
}

?>
