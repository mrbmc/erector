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

	public $controller = "Controller";
	public $action = "index";
	public $view = "index";
	public $params;
	public $format = false;

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

		//catch the dot suffix for formatting
		if(stristr($_SERVER['REDIRECT_URL'],".")) {
			$tmp = explode(".",$_SERVER['REDIRECT_URL']);
			$url = $tmp[0];
			$this->format = strtolower(trim($tmp[1]));
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
		if(count($args)<=0)
			return;

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

		// invalid controller specified
		if(strtolower($this->controller)!=strtolower($args[0])) {
			$this->view = $this->params['id'] = $args[0];
			if($args[0]!=$this->action && $this->action!='index') {
					$this->controller = "Profile";
					$this->action = "show";
			}
			//Debugger::trace('dispatcher',Dispatcher::instance(),true);
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
//		Debugger::trace('path',$path,true);
//		Debugger::trace('controller',$controller,true);
		if(file_exists($path)) 
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

//		echo $this->controllerInstance->format;
		//Debugger::trace('dispatcher',Dispatcher::instance(),true);
	}
}

?>
