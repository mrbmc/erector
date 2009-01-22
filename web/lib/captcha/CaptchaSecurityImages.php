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

class CaptchaSecurityImages {

	private $font = "./lib/captcha/monofont.ttf";
	private $possible = '23456789bcdfghjkmnpqrstvwxyz';
	private $width;
	private $height;
	private $length;
	public $code;

	/**
	 * Constructor
	 */
	function CaptchaSecurityImages($width='120',$height='40') {
		if(!$_SESSION)
			session_start();

		$this->width = $width;
		$this->height = $height;
		$this->length = 5;

		$this->code = $_SESSION['captcha_code']!=""?$_SESSION['captcha_code']:$this->generateCode();
		$_SESSION['captcha_code'] = $this->code;
	}


	/**
	 *	Print the captcha image
	 */
	function image () {
		$width = ($_GET['width']>0) ? $_GET['width'] : $this->width;
		$height = ($_GET['height']>0) ? $_GET['height'] : $this->height;

		/* font size will be 75% of the image height */
		$font_size = $height * 0.75;
		$image = @imagecreate($width, $height) or die('Cannot initialize new GD image stream');

		/* set the colours */
		$background_color = imagecolorallocate($image, 255, 255, 255);
		$noise_color = imagecolorallocate($image, 180, 45, 180);
		$text_color = imagecolorallocate($image, 0, 0, 120);

		/* generate random dots in background */
		for( $i=0; $i<($width * $height)/10; $i++ ) {
			imagefilledellipse($image, mt_rand(0,$width), mt_rand(0,$height), 2, 2, $noise_color);
		}

		/* generate random lines in background */
		for( $i=0; $i<($width * $height)/150; $i++ ) {
			imageline($image, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $noise_color);
		}

		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $this->code) or die('Error in imagettfbbox function');
		$x = ($width - $textbox[4])/2;
		$y = ($height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $text_color, $this->font , $this->code) or die('Error in imagettftext function');

		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);
		exit();
	}


	/**
	 *	Generate the text code
	 */
	function generateCode() {
		/* list all possible characters, similar looking characters and vowels have been removed */
		$code = '';
		for ($i = 0; $i < $this->length; $i++) {
			$code .= substr($this->possible, mt_rand(0, strlen($this->possible)-1), 1);
		}
		return $code;
	}


	/**
	 * Check that the post is correct
	 */
	function validate ($input_code) {
		return ($this->code == $input_code);
	}
}

?>