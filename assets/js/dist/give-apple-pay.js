'use strict';

/**
 * Create Apple Pay session and pass stripe token to our
 * server. If successful, we'll create a stripe charge
 * create a donation in giveWP
 */
(function (document, $, undefined) {

	/**
  * Provide publishable key and connected account ID to Stripe
  */
	// const stripe = Stripe(
	// 	giveApplePayVars.publishable_key,
	// 	{ stripeAccount: giveApplePayVars.user_id }
	// )
	var stripe = Stripe(give_stripe_vars.publishable_key);

	/**
  * Set property to your connected account's Stripe ID
  */
	Stripe.applePay.stripeAccount = giveApplePayVars.user_id;

	/**
  * checkAvailability() is an asynchronous call.
  *
  * It returns immediatelyand invokes stripeResponseHandler when it
  * has determined if Apple Pay is available.
  */
	Stripe.applePay.checkAvailability(stripeResponseHandler);

	/**
  * Run applePayButtonClicked () when apple pay button is clicked
  */
	document.getElementById('apple-pay-button').addEventListener('click', applePayButtonClicked);

	/**
  * Our entry point for Apple Pay interactions.
  * Triggered when the Apple Pay button is pressed
  */
	function applePayButtonClicked() {

		/**
   * Builds an ApplePaySession object, which manages the Apple Pay
   * experience for your user.
   */
		var session = Stripe.applePay.buildSession(paymentRequest, onSuccessHandler, onErrorHandler);

		/**
   * User canceled Apple Pay payment by clicking the x in modal
   */
		session.oncancel = function () {
			console.log('User hit the cancel button in the payment window');
		};

		/**
   * Start Apple Pay payment
   */
		session.begin();
	}

	/**
  * paymentRequest object
  */
	var paymentRequest = {
		countryCode: 'US',
		currencyCode: give_stripe_vars.currency,
		total: {
			label: give_stripe_vars.sitename,
			amount: getFormTotal()
		}

		/**
   * Log any errors in applePay.buildSession
   */
	};function onErrorHandler(error) {
		console.error(error.message);
	}

	/**
  * onSuccessHandler in applePay.buildSession
  */
	function onSuccessHandler(result, completion) {
		$.post("/charges", { token: result.token.id }).done(function () {
			console.log(result.token.card.address_line1);
			console.log(result.shippingContact.phoneNumber);

			completion(true);
		}).fail(function () {

			completion(false);
		});
	}

	/**
  * Get Apple Pay Form Total. Total must be formatted as a string
  *
  * @returns {string}
  */
	function getFormTotal() {
		return document.querySelector('.give-final-total-amount').innerText.replace('$', '').replace(',', '');
	}

	/**
  * Change the CSS display property on the apple pay button
  */
	function showApplePayButton() {
		document.getElementById('apple-pay-button').style.display = 'block';
	}

	/**
  * If Apple Pay is available, display the button on your checkout page
  *
  * @param available
  */
	function stripeResponseHandler(available) {
		if (available) showApplePayButton();
	}
})(document, jQuery);

/**
 * Wrapper around applePay.buildSession
 *
 * @param e
 */
// function beginApplePay(e) {
//
// 	e.preventDefault()
//
//
// 	const session = Stripe.applePay.buildSession(paymentRequest, function (result, completion) {


// const nonce = giveApplePayVars.endpoint_params.stripe_apple_pay_nonce

// const data = {
// 	action: "give_apple_pay_get_result_object",
// 	form: form,
// 	'nonce' : nonce,
// 	'result': result
// };


// $.post(giveAjaxUrl, data).done(function () {
// 	console.log(result)
// 	console.log(paymentRequest)
// 	console.log(completion)
//
// 	completion(ApplePaySession.STATUS_SUCCESS)
//
// 	// You can now redirect the user to a receipt page, etc.
// 	// window.location.href = giveApplePayVars.succes_redirect
//
// }).fail(function () {
// 	completion(ApplePaySession.STATUS_FAILURE)
// })


// 		const giveAjaxUrl = giveApplePayVars.endpoint_params.ajaxurl
// 		const nonce = give_global_vars.checkout_nonce
//
// 		const form = new FormData(this)
//
// 		console.log(result)
//
//
// 		$.ajax({
// 			type: 'POST',
// 			data: {
// 				action: 'give_apple_pay_get_stripe_token',
// 				form  : form,
// 				'nonce' : nonce,
// 				'result': result
// 			},
// 			url: giveAjaxUrl,
// 			success: (response) => {
// 				console.log(response)
//
// 				if ('true' === response.success) {
// 					completion(ApplePaySession.STATUS_SUCCESS)
// 					//window.location.href = response.redirect
// 				}
//
// 				if ('false' === response.success) {
// 					completion(ApplePaySession.STATUS_FAILURE)
//
// 					$('.apple-pay-button').before('<p class="give-error wc-stripe-apple-pay-error">' + response.msg + '</p>')
// 					$(document.body).animate({scrollTop: $('.wc-stripe-apple-pay-error').offset().top}, 500)
// 				}
// 			},
// 			error: (data) => {
// 				console.log(data);
//
// 				completion(ApplePaySession.STATUS_FAILURE)
// 			}
// 		})
// 	}, (error) => {
// 		console.log(error)
// 	})
//
//
//
// 	session.oncancel = () => {
// 		console.log("User hit the cancel button in the payment window")
// 	}
//
// 	session.begin()
//
//
// }