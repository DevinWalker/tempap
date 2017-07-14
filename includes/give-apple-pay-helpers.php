<?php
/**
 * Give Apple Pay Helper Functions
 *
 * @package     Give Apple Pay
 * @copyright   Copyright (c) 2017, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/**
 * Check user agent if mobile safari
 *
 * @return bool
 */
function give_apple_pay_is_mobile_safari() {
	$browser_string = $_SERVER['HTTP_USER_AGENT'];

	if ( strstr( $browser_string, ' AppleWebKit/' ) && strstr( $browser_string, ' Mobile/' ) ) {
		return true;
	}
}

