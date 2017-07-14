<?php
/**
 * Give Apple Pay Assets
 *
 * @package     Give Apple Pay
 * @copyright   Copyright (c) 2017, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}



add_action( 'wp_enqueue_scripts', 'give_apple_pay_front_end_assets' );
/**
 * Enqueue frontend assets
 */
function give_apple_pay_front_end_assets() {

	if ( give_is_test_mode() ) {
		$test_pub_key    = give_get_option( 'test_publishable_key' );
		$publishable_key = isset( $test_pub_key ) ? trim( $test_pub_key ) : '';
	} else {
		$live_pub_key    = give_get_option( 'live_publishable_key' );
		$publishable_key = isset( $live_pub_key ) ? trim( $live_pub_key ) : '';
	}

	$give_apple_pay_vars = get_give_stripe_connect_options();

	$give_apple_pay_vars['endpoint_params'] = [
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'stripe_apple_pay_nonce' => wp_create_nonce( '_wc_stripe_apple_pay_nonce' ),
	];

	$give_apple_pay_vars['success_redirect'] = give_get_success_page_uri();
	$give_apple_pay_vars['publishable_key'] = $publishable_key;



	wp_register_script(
		'stripe-v2-js',
		'https://js.stripe.com/v2/',
		[ 'jquery' ],
		'2.0',
		true
	);

	wp_register_script(
		'stripe-v3-js',
		'https://js.stripe.com/v3/',
		[ 'jquery' ],
		'3.0',
		true
	);

	wp_register_script(
		'give-apple-pay-js',
		GIVE_APPLE_PAY_URL . 'assets/js/dist/give-apple-pay.js',
		[ 'jquery', 'stripe-v2-js', 'stripe-v3-js' ],
		GIVE_APPLE_PAY_VERSION,
		true
	);


	wp_register_script(
		'give-apple-pay-stripe',
		GIVE_APPLE_PAY_URL . 'assets/js/dist/give-apple-pay-stripe.js',
		[ 'jquery', 'stripe-v2-js', 'stripe-v3-js' ],
		GIVE_STRIPE_VERSION,
		true
	);

	wp_enqueue_script( 'stripe-v2-js' );
	wp_enqueue_script( 'stripe-v3-js' );

	wp_enqueue_script( 'give-apple-pay-js' );
	wp_enqueue_script( 'give-apple-pay-stripe' );

	wp_localize_script( 'give-apple-pay-js', 'giveApplePayVars', $give_apple_pay_vars );

}
