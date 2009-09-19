<?php

//Presentation formats
include_once LIB.'/smarty/Smarty.class.php';				//HTML Template engine
//include_once LIB.'/captcha/CaptchaSecurityImages.php';		//CAPTCHA turing test

/**
 * PRESENTER CLASS
 * @description Loads a template engine and generates the output.
 */

class Presenter 
{
	private $controller;
	private $view;
	private $format;
	private $smarty;
	private $OUTPUT;

	public function __construct () {
		$this->controller = Dispatcher::instance()->controllerInstance;
		$format = (isset($_GET['format'])) ? $_GET['format'] : $this->controller->format;
		$this->$format();
	}

	private function validateTemplate () {
		$this->view = $this->controller->view;
		if(stristr($this->view,".tpl")===false)
			$this->view .= ".tpl";

		if(!file_exists(APP . "/views/" . $this->view))
			$this->view = "./errors/404.tpl";
		//Debugger::trace($this->view);
	}


	//Compile the view
	private function compile () {
		$this->smarty = new Smarty();
		$this->smarty->template_dir = APP.'/views';
		$this->smarty->compile_dir = $this->smarty->cache_dir = LIB.'/../cache';
		$this->smarty->config_dir = LIB.'/smarty/configs';
		$this->smarty->caching = !DEBUG;
		$this->smarty->force_compile = DEBUG;
		$this->smarty->debugging = DEBUG;

//		Debugger::trace($this->smarty);

		$this->validateTemplate();

		$this->smarty->assign('DISPATCHER', object_to_array(Dispatcher::instance()));
		$this->smarty->assign('CONFIG', object_to_array(Config::instance()));
		$this->smarty->assign('DOCROOT', Config::instance()->DOCROOT);
		$this->smarty->assign('DATA', object_to_array($this->controller));
		if(!DEBUG)
			$this->smarty->assign('ERRORS', Debugger::$console);
		$this->OUTPUT = $this->smarty->fetch($this->view);
	}



	private function isNotAssocArray($arr)
	{
	    return (0 !== array_reduce(
	        array_keys($arr),
	        create_function('$a, $b', 'return ($b === $a ? $a + 1 : 0);'),
	        0
	        )
	    );
	}
	private function objToXML ($obj) {
		$str = "";
		if(is_object($obj)) {
			$str .= "<". strtolower(get_class($obj)) . ">";
			foreach($obj as $k => $v)
			{
				$str .= is_object($v) ? $this->objToXML($v) : (is_array($v) ? "<$k>".$this->objToXML($v)."</$k>" : "<$k><![CDATA[$v]]></$k>");
			}
			$str .= "</". strtolower(get_class($obj)) . ">";
		} elseif (is_array($obj) && $this->isNotAssocArray($obj)) {
			foreach ($obj as $k=>$v)
			{
				$str .= is_array($v) ? "<$v>".$this->objToXML($v)."</$v>" : (is_object($v) ? $this->objToXML($v) : "<$v />");
			}
		} elseif (!$this->isNotAssocArray($obj)) {
			foreach($obj as $k => $v)
			{
				$str .= "<$k><![CDATA[$v]]></$k>";
			}
		} else {
			$str .= "<$k>$v</$k>";
		}
		return $str;
	} 
	private function xml () {
		header("Content-type: text/xml");
		$this->OUTPUT .= "<".Dispatcher::instance()->controller.">";
		$this->OUTPUT .= $this->objToXML($this->controller->xml);
		$this->OUTPUT .= "</".Dispatcher::instance()->controller.">";
		print $this->OUTPUT;
	}





	private function json () {
		header("Content-type: text/plain");
		$this->OUTPUT = json_encode($this->controller);
		print $this->OUTPUT;
	}

	private function is_box($obj) {
		return (is_array($obj) || is_object($obj));
	}
	private function objToCSV ($obj) {
		$str = "";
		foreach($obj as $o)
		{
			$hdr = "";
			foreach($o as $k => $v)
			{
				$hdr .= "\"$k\",";
				$str .= $this->is_box($v) ? "\n".$this->objToCSV($v) : "\"$v\",";
			}
			$str .= "\n";
		}
		return $hdr."\n".$str;
	} 
	private function xls () {
		$this->OUTPUT .= $this->objToCSV($this->controller->data);

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=\"".$this->controller->title.".csv\";" );
		header("Content-Transfer-Encoding: binary");

		print $this->OUTPUT;
	}
	private function csv () { 
		$this->OUTPUT .= $this->objToCSV($this->controller->data);
		header("Content-type: text/plain");
		print $this->OUTPUT;
	}


	private function pdf () {
		include_once LIB.'/dompdf/dompdf_config.inc.php';			//PDF Generation Class
		$dompdf = new DOMPDF();
		$dompdf->set_paper("letter","portrait");
		$dompdf->load_html($this->OUTPUT);
		$dompdf->render();
		$dompdf->stream($this->controller->title . ".pdf",array("Attachment"=>0));
	}
	
	private function email () {
		include_once LIB.'/mailers/PHPMailer.class.php';			//Email sending class
		$this->compile();

		$mail = new PHPMailer();
		$mail->Host     = "localhost";
		//$mail->Mailer   = "smtp";

	    $mail->Body    = $this->OUTPUT;
	    $mail->AltBody = strip_tags($this->OUTPUT);
		$mail->Subject = $this->controller->title;

		$mail->From     = isset($this->controller->EMAIL_FROM) ? $this->controller->EMAIL_FROM : Config::instance()->EMAIL_ADDRESS;
		$mail->FromName = isset($this->controller->EMAIL_FROM) ? $this->controller->EMAIL_FROM : Config::instance()->EMAIL_NAME;

//		if(isset($_REQUEST['EMAIL'])) {
//			array_push($this->controller->EMAIL_LIST,array($_REQUEST['EMAIL']));
//		}

		foreach($this->controller->EMAIL_LIST as $toAddy)
		{
		    $mail->AddAddress($toAddy);
		    if(!$mail->Send())
		        die("There has been a mail error sending to " . $toAddy);
		    $mail->ClearAddresses();
		    $mail->ClearAttachments();
		}

		if(isset($this->controller->redirect)) {
			header("Location: ".$this->controller->redirect);
		} else {
			header("Content-type: text/html");
			print $this->OUTPUT;
		}	
	}
	
	private function text () {
		$this->compile();

		header("Content-type: text/plain");
		print $this->OUTPUT;
	}
	
	private function html () {
		if(isset($this->controller->redirect)) 
			return header("Location: ".$this->controller->redirect);
		$this->compile();
		header("Content-type: text/html");
		print $this->OUTPUT;
	}
	


}





?>