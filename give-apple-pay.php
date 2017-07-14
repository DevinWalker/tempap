<?php
/**
 * Plugin Name: Give - Apple Pay Gateway
 * Plugin URI:  https://luminfire.com/
 * Description: A Give Add-on that enables Apple Pay checkout on mobile safari using Stripe.
 * Version:     0.0.1
 * Author:      LuminFire
 * Author URI:  https://luminfire.com/
 * License:     GNU General Public License v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: giveapplepay
 */


/**
 * Give Apple Pay directory
 */
if ( ! defined( 'GIVE_APPLE_PAY_DIR' ) ) {
	define( 'GIVE_APPLE_PAY_DIR', __DIR__ );
}

/**
 * Plugin URL
 */
if ( ! defined( 'GIVE_APPLE_PAY_URL' ) ) {
	define( 'GIVE_APPLE_PAY_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Apple Pay basename
 */
if ( ! defined( 'GIVE_APPLE_PAY_BASENAME' ) ) {
	define( 'GIVE_APPLE_PAY_BASENAME', plugin_basename( __FILE__ ) );
}

/**
 * Give Apple Pay version
 */
if ( ! defined( 'GIVE_APPLE_PAY_VERSION' ) ) {
	define( 'GIVE_APPLE_PAY_VERSION', '0.0.1' );
}

/**
 * Minimum GiveWP version required to activate plugin
 */
if ( ! defined( 'GIVE_APPLE_PAY_MIN_GIVE_VER' ) ) {
	define( 'GIVE_APPLE_PAY_MIN_GIVE_VER', '1.7' );
}


add_action( 'plugins_loaded', 'give_apple_pay_init' );
/**
 * Initialize plugin
 */
function give_apple_pay_init() {
	if ( ! class_exists( 'Give' ) ) {
		return false;
	}

	if ( is_admin() ) {
		include GIVE_APPLE_PAY_DIR . '/includes/admin/give-apple-pay-activation.php';
		include GIVE_APPLE_PAY_DIR . '/includes/admin/give-apple-pay-settings.php';
	}

//	include GIVE_APPLE_PAY_DIR . '/whoops.php';
	include GIVE_APPLE_PAY_DIR . '/tracy.php';
	include GIVE_APPLE_PAY_DIR . '/includes/give-apple-pay-helpers.php';
	include GIVE_APPLE_PAY_DIR . '/includes/give-apple-pay-assets.php';
	include GIVE_APPLE_PAY_DIR . '/includes/give-apple-pay-gateway.php';

}

