'use strict';

(function (document, $, undefined) {

	/**
  * Provide publishable key and connected account ID to Stripe
  */
	var stripe = Stripe(give_stripe_vars.publishable_key);

	/**
  * Create a token when the form is submitted.
  *
  * @type {Element}
  */
	var form = document.querySelector('.give-form');
	form.addEventListener('submit', function (e) {
		e.preventDefault();
		createToken();
	});

	/**
  * Insert the token ID into the form so it gets submitted to the server
  *
  * @param token
  */
	var stripeTokenHandler = function stripeTokenHandler(token) {
		var form = document.querySelector('.give-form');
		var hiddenInput = document.createElement('input');

		hiddenInput.setAttribute('type', 'hidden');
		hiddenInput.setAttribute('name', 'stripeToken');
		hiddenInput.setAttribute('value', token.id);

		form.appendChild(hiddenInput);
		form.submit();
	};

	/**
  * Create/Send the token to your server
  */
	function createToken() {
		stripe.createToken(card).then(function (result) {
			if (result.error) {
				var errorElement = document.getElementById('card-errors');
				errorElement.textContent = result.error.message;
			} else {
				stripeTokenHandler(result.token);
			}
		});
	}
})(document, jQuery);

/**
 * Give - Stripe Gateway Add-on JS
 */
// var give_global_vars, give_stripe_vars;
//
// jQuery(document).ready(function ($) {
//
// 	Stripe.setPublishableKey(give_stripe_vars.publishable_key);
//
// 	var $body = jQuery('body');
//
// 	//Setup stripe token on submit
// 	$body.on('submit', '.give-form', function (event) {
//
// 		var $form = jQuery(this);
//
// 		if ($form.find('input.give-gateway:checked').val() == 'stripe') {
//
// 			event.preventDefault();
//
// 			$form.addClass('stripe-checkout');
//
// 			give_stripe_process_card($form);
// 		}
// 	});
// });

/**
 * Stripe Process CC
 *
 * @param  $form object
 * @returns {boolean}
 */
// function give_stripe_process_card($form) {
//
// 	// disable the submit button to prevent repeated clicks
// 	$form.find('[id^=apple-pay-button]').attr('disabled', 'disabled');
//
// 	// createToken returns immediately - the supplied callback submits the form if there are no errors
// 	Stripe.createToken({}, giveApplePayStripeResponseHandler);
//
// 	return false; // submit from callback
// }