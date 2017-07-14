<?php
/**
 * Create Apple Pay admin area
 *
 * @package     Give Apple Pay
 * @copyright   Copyright (c) 2017, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_filter( 'give_payment_gateways', 'give_apple_pay_register_gateway' );
/**
 * Register Give Apple Pay gateway
 *
 * @param $gateways array | give payment gateways
 *
 * @return mixed
 */
function give_apple_pay_register_gateway( $gateways ) {
	$gateways['apple_pay']     = [
		'admin_label'    => __( 'Stripe - Apple Pay', 'giveapplepay' ),
		'checkout_label' => __( 'Stripe - Apple Pay', 'giveapplepay' ),
	];

	return $gateways;
}

add_filter( 'give_settings_gateways', 'give_apple_pay_add_metaboxes' );
/**
 * Register the gateway settings
 *
 * @since 1.0
 *
 * @param array $settings
 *
 * @return array
 */
function give_apple_pay_add_metaboxes( $settings ) {

	$give_apple_pay_settings = [

		[
			'name' => '<strong>' . __( 'Apple Pay', 'giveapplepay' ) . '</strong>',
			'desc' => '<hr>',
			'id'   => 'give_title_give_apple_pay',
			'type' => 'give_title',
		],
		[
			'name' => __( 'Enable Apple Pay Checkout', 'giveapplepay' ),
			'desc' => sprintf( __( 'This option will enable <a href="%s" target="_blank">Apple Pay</a> in Stripe\'s modal checkout where the donor can complete the donation with Apple Pay on mobile Safari.',	'giveapplepay' ), 'https://stripe.com/docs/apple-pay/web' ),
			'id'   => 'give_apple_pay_checkout_enabled',
			'type' => 'checkbox',
		]

	];

	return array_merge( $settings, $give_apple_pay_settings );
}

