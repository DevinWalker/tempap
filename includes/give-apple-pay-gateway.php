<?php
/**
 * Give Apple Pay Gateway
 *
 * @package     Give Apple Pay
 * @copyright   Copyright (c) 2017, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       1.2
 */



if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


add_action( 'give_donation_form_after_submit', 'give_apple_pay_add_checkout_button_to_modal' );
/**
 * Add Apple Pay checkout button to modal
 */
function give_apple_pay_add_checkout_button_to_modal() {
	echo '<div class="give-submit-button-wrap give-clearfix">';

	echo '<button id="apple-pay-button"
				  style="background-color: black;
						 background-image: -webkit-named-image(apple-pay-logo-white);
						 background-size: 100% 100%;
						 background-origin: content-box;
						 background-repeat: no-repeat;
						 margin-top: 20px;
						 width: 100%;
						 height: 44px;
						 padding: 10px 0;
						 border-radius: 10px;"
		  ></button>';

	echo '</div>';
}



add_action( 'init', 'give_apple_pay_register_domain' );
/**
 * Set up Apple Pay with Stripe Connect (optional)
 *
 * @link https://stripe.com/docs/apple-pay/web#connect
 */
function give_apple_pay_register_domain() {
	$site_url = site_url();
	$find = array( 'http://', 'https://', 'www.' );
	$formatted_site_url = str_replace( $find, '', $site_url );

	$key = Give_Stripe_Gateway::get_secret_key();

//	if ( 'applepay.kbox.site' || 'edge.applepay.kbox.site' === $formatted_site_url ) {
//		return;
//	}

	\Stripe\Stripe::setApiKey( $key );
	\Stripe\ApplePayDomain::create(
		array( 'domain_name' => $formatted_site_url ),
		array( 'stripe_account' => give_get_option( 'give_stripe_user_id' ) )
	);



//	$give_stripe_gateway = new Give_Stripe_Gateway();
//	$give_stripe_gateway->process_charge( $posted, $donation_data );

}


add_action( 'wp_ajax_give_apple_pay_get_stripe_token', 'give_apple_pay_get_stripe_token' );
add_action( 'wp_ajax_nopriv_give_apple_pay_get_stripe_token', 'give_apple_pay_get_stripe_token' );
/**
 *
 */
function give_apple_pay_get_stripe_token () {

	$token = $_POST['stripeToken'];
	$form = $_POST['form'];

	die( $token );

	if ( null !== $_POST['stripeToken'] ) {
		echo '<pre>';
		var_dump( $_POST );
		echo '</pre>';
	}

	if ( isset( $_POST['form'] ) ) {

		echo '<pre>';
		var_dump( $_POST );
		echo '</pre>';

		parse_str( $_POST['form'], $form );
		die( json_encode( $form ) );
	}
}
