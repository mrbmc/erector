<?php

/**
 * ------------------------------------------------------------
 * CONTROL
 */
include_once LIB.'/captcha/CaptchaSecurityImages.php';
$captcha = new CaptchaSecurityImages();

/**
 * ------------------------------------------------------------
 * MODEL
 */


/**
 * ------------------------------------------------------------
 * VIEW
 */
$captcha->image();

?>