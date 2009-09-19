<?php
/**
 * File: CaptchaSecurityImages.php
 * Author: Simon Jarvis
 * Copyright: 2006 Simon Jarvis
 * Date: 03/08/06
 * Updated: 07/02/07
 * Requirements: PHP 5 with GD and FreeType libraries
 * Link: http://www.white-hat-web-design.co.uk/articles/php-captcha.php
 * 
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details:
 * http://www.gnu.org/licenses/gpl.html
 * 
 * EXAMPLE USAGE:
 * instantiate:		$captcha = new CaptchaSecurityImages();
 * image:			<img src="/captcha/{width}/{height}" />
 * validate: 		$captcha->validate($_REQUEST['security_code']);
 */

class CaptchaSecurityImages 
{
	public $width = 150;
	public $height = 50;
	public $length = 5;
	public $code;

	private $font = "./lib/captcha/monofont.ttf";
	private $possible = '23456789bcdfghjkmnpqrstvwxyz';
	private $image;

	public function __construct($w=null,$h=null,$l=null) {
		Session::instance();

		$this->width = $w ? $w : $this->width;
		$this->height = $h ? $h : $this->height;
		$this->length = $l ? $l : $this->length;

		$this->code = $_SESSION['captcha_code']!=""?$_SESSION['captcha_code']:$this->generateCode();
		$_SESSION['captcha_code'] = $this->code;

		$this->image = $this->generateImage();
	}

	public function generateCode() {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$_code = '';
		for ($i = 0; $i < $this->length; $i++) {
			$_code .= substr($this->possible, mt_rand(0, strlen($this->possible)-1), 1);
		}
		return $_code;
	}

	protected function generateImage () {
		/* font size will be 75% of the image height */
		$font_size = $this->height * 0.75;
		$_image = @imagecreate($this->width, $this->height) or die('Cannot initialize new GD image stream');

		/* set the colours */
		$background_color = imagecolorallocate($_image, 255, 255, 255);
		$noise_color = imagecolorallocate($_image, 180, 45, 180);
		$text_color = imagecolorallocate($_image, 0, 0, 120);

		/* generate random dots in background */
		for( $i=0; $i<($this->width * $this->height)/10; $i++ ) {
			imagefilledellipse($_image, mt_rand(0,$this->width), mt_rand(0,$this->height), 2, 2, $noise_color);
		}

		/* generate random lines in background */
		for( $i=0; $i<($this->width * $this->height)/150; $i++ ) {
			imageline($_image, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $noise_color);
		}

		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $this->code) or die('Error in imagettfbbox function');
		$x = ($this->width - $textbox[4])/2;
		$y = ($this->height - $textbox[5])/2;
		imagettftext($_image, $font_size, 0, $x, $y, $text_color, $this->font , $this->code) or die('Error in imagettftext function');

		return $_image;
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