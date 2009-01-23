<?php
include_once LIB.'/captcha/CaptchaSecurityImages.php';
class Captcha extends Controller
{
	private $captcha;

	public function __construct() {
		parent::__construct("Captca");
		$this->captcha = new CaptchaSecurityImages(150,50,5);
		$this->action();
	}

	protected function index() {
		$this->captcha->present();
	}
	protected function validate () {
		echo ($this->captcha->code == $_GET['captcha']) ? "true" : "false";
		exit;
	}
	protected function renew()
	{
		$this->captcha->code = $this->captcha->generateCode();
		$_SESSION['captcha_code'] = $this->captcha->code;
		echo $this->captcha->code;
		exit;
	}
}
?>