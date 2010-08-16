<?php

class CaptchaPictures 
{
	private $num_of_choices = 4;
	public $question;
	public $answer;
	public $choices = array();
	public $images = array();

	public function __construct() {
	}

	public function create ($_count=null) {
		if(is_numeric($_count) && $_count>0) $this->num_of_choices = $_count;
		//$s = Session::instance();
		$d = dir(WEBROOT.'/images/captcha/');
		while (false !== ($entry = $d->read())) {
			if ($entry != '.' && $entry != '..' && $entry != 'show.php' && $entry != '.htaccess' && $entry != 'Thumbs.db' &&  $entry != '.svn')
				$this->images[] = $entry; 
		}
		$d->close();
		$image_count = count($this->images);
		for($i=0;$i<$this->num_of_choices;$i++) {
			$tmp = rand(1,$image_count)-1;
			foreach($this->choices as $k=>$v) {
				if($v[0]==$tmp)
					$tmp = rand(1,$image_count)-1;
			}
			$this->choices[] = array($tmp,$this->images[$tmp],'<img src="/images/captcha/'.$this->images[$tmp].'" />');
		}

		$this->answer = rand(1,$this->num_of_choices);
		$this->question = substr($this->choices[$this->answer-1][1],0,-4);

		$_SESSION['question'] = $this->question;
		$_SESSION['answer'] = md5($this->answer);
		$_SESSION['choices'] = $this->choices;
	}

	public function validate ($input) {
//		if (!isset($_SESSION['secure'])) {
//			if (!$_GET['clicked']) {
//			}
//			else {
//				if (md5($input) == $_SESSION['answer']) $_SESSION['secure'] = 1;
//				else $badchoice = 1;
//			}
//		}
		return (md5(trim($input)) == $_SESSION['answer']);
	}

	public function present() {
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($this->image);
		imagedestroy($this->image);
		exit();
	}

}

?>