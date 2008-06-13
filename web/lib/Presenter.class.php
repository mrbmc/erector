<?php

//Presentation formats
include_once LIB.'/SMARTY/Smarty.class.php';				//HTML Template engine
include_once LIB.'/Email/PHPMailer.class.php';				//Email sending class
include_once LIB.'/DOMPDF/dompdf_config.inc.php';			//PDF Generation Class
include_once LIB.'/captcha/CaptchaSecurityImages.php';	//CAPTCHA turing test

/**
 * PRESENTER CLASS
 * @author brian@eislabs.com
 * @description Loads a template engine and generates the output.
 * @todo Create an abstract class, and subclasses for each format
 */

class Presenter 
{
	var $smarty;
	var $format;
	var $OUTPUT;
	private $action;

	public function __construct () {
		global $CONFIG;
		$this->action = $GLOBALS['ACTION'];

		$format = (isset($_GET['format'])) ? $_GET['format'] : $this->action->format;
		$this->$format();
	}


	//Compile the templates
	private function compile ($_action) {
		global $CONFIG;
		$this->smarty = new Smarty();
		$this->smarty->template_dir = './templates';
		$this->smarty->compile_dir = $this->smarty->cache_dir = './lib/SMARTY/cache';
		$this->smarty->config_dir = './lib/SMARTY/configs';
		$this->smarty->caching = !DEBUG;
		$this->smarty->force_compile = DEBUG;
		$this->smarty->debugging = DEBUG;

		$this->smarty->assign('DOCROOT', $CONFIG->DOCROOT);
		$this->smarty->assign('DATA', $_action->toArray());
		$this->OUTPUT = $this->smarty->fetch($_action->template);
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
		$this->OUTPUT .= $this->objToXML($this->action);
		print $this->OUTPUT;
	}





	private function json () {
		header("Content-type: text/plain");
		$this->OUTPUT = json_encode($GLOBALS['ACTION']);
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
				$hdr .= "$k	";
				$str .= $this->is_box($v) ? "\n".$this->objToCSV($v) : "$v	";
			}
			$str .= "\n";
		}
		return $hdr."\n".$str;
	} 
	private function xls () {
		$this->OUTPUT .= $this->objToCSV($this->action->template);

		header("Pragma: public"); // required
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false); // required for certain browsers 
		header("Content-Type: application/vnd.ms-excel");
		// change, added quotes to allow spaces in filenames, by Rajkumar Singh
		header("Content-Disposition: attachment; filename=\"dashboard.csv\";" );
		header("Content-Transfer-Encoding: binary");
		//header("Content-Length: ".filesize($filename));

//		header("Content-Type: text/plain");
		print $this->OUTPUT;
	}
	private function csv () { $this->xls(); }




	private function pdf () {
		$dompdf = new DOMPDF();
		$dompdf->set_paper("letter","portrait");
		$dompdf->load_html($this->OUTPUT);
		$dompdf->render();
		$dompdf->stream($this->action->title . ".pdf",array("Attachment"=>0));
	}
	
	private function email () {
		if(is_string($this->action->template))
			$this->compile($this->action);

		$mail = new PHPMailer();
		$mail->Host     = "localhost";
		//$mail->Mailer   = "smtp";

	    $mail->Body    = $this->OUTPUT;
	    $mail->AltBody = strip_tags($this->OUTPUT);
		$mail->Subject = $GLOBALS['ACTION']->title;

		$mail->From     = isset($GLOBALS['ACTION']->EMAIL_FROM) ? $GLOBALS['ACTION']->EMAIL_FROM : "no-reply@edelmanstudios.com";
		$mail->FromName = isset($GLOBALS['ACTION']->EMAIL_FROM) ? $GLOBALS['ACTION']->EMAIL_FROM : $GLOBALS['CONFIG']->EMAIL_NAME;

//		if(isset($_REQUEST['EMAIL'])) {
//			array_push($GLOBALS['ACTION']->EMAIL_LIST,array($_REQUEST['EMAIL']));
//		}

		foreach($GLOBALS['ACTION']->EMAIL_LIST as $toAddy)
		{
		    $mail->AddAddress($toAddy);
		    if(!$mail->Send())
		        echo "There has been a mail error sending to " . $toAddy . "<br>";
		    $mail->ClearAddresses();
		    $mail->ClearAttachments();
		}

		if(isset($GLOBALS['ACTION']->redirect)) {
			header("Location: ".$GLOBALS['ACTION']->redirect);
		} else {
			header("Content-type: text/html");
			print $this->OUTPUT;
		}	
	}
	
	private function text () {
		if(is_string($this->action->template))
			$this->compile($this->action);

		header("Content-type: text/plain");
		print $this->OUTPUT;
	}
	
	private function html () {
		if(is_string($this->action->template))
			$this->compile($this->action);

		if(isset($GLOBALS['ACTION']->redirect)) 
			return header("Location: ".$GLOBALS['ACTION']->redirect);
		header("Content-type: text/html");
		print $this->OUTPUT;
	}
	


}





?>