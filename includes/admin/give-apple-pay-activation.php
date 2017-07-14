<?php
/**
 * Give Apple Pay activation file. Includes version and plugin checks.
 *
 * @package     Give Apple Pay
 * @copyright   Copyright (c) 2016, WordImpress
 * @license     https://opensource.org/licenses/gpl-license GNU Public License
 * @since       0.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display Give Activation Banner if our checks pass
 *
 * @since 0.0.1
 */

add_action( 'admin_init', 'give_apple_pay_activation_checks' );

function give_apple_pay_activation_checks() {

	$is_give_active = defined( 'GIVE_PLUGIN_BASENAME' ) ? is_plugin_active( GIVE_PLUGIN_BASENAME ) : false;

	if ( ! $is_give_active && is_admin() && current_user_can( 'activate_plugins' ) ) {

		give_apple_pay_deactivate_plugin( 'give_apple_pay_inactive_notice_give', GIVE_APPLE_PAY_BASENAME );

		return false;

	}

	$is_give_stripe_active = defined( 'GIVE_STRIPE_BASENAME' ) ? is_plugin_active( GIVE_STRIPE_BASENAME ) : false;

	if ( ! $is_give_stripe_active && is_admin() && current_user_can( 'activate_plugins' ) ) {

		give_apple_pay_deactivate_plugin( 'give_apple_pay_inactive_notice_give_stripe', GIVE_APPLE_PAY_BASENAME );

		return false;

	}

	if ( version_compare( GIVE_VERSION, GIVE_APPLE_PAY_MIN_GIVE_VER, '<' ) ) {

		give_apple_pay_deactivate_plugin( 'give_apple_pay_version_notice', GIVE_APPLE_PAY_BASENAME );

		return false;

	}

	if ( class_exists( 'Give_Addon_Activation_Banner' ) ) {
		give_apple_pay_activation_banner();
	}

	return false;

}


/**
 * Notification that Give must be installed and activated
 *
 * @since 0.0.1
 */
function give_apple_pay_inactive_notice_give() {
	echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> You must have the <a href="https://givewp.com/" target="_blank">Give</a> plugin installed and activated for the Apple Pay Add-on to activate.', 'giveapplepay' ) . '</p></div>';
}


/**
 * Notification that Give Stripe must be installed and activated
 *
 * @since 0.0.1
 */
function give_apple_pay_inactive_notice_give_stripe() {
	echo '<div class="error"><p>' . __( '<strong>Activation Error:</strong> You must have the <a href="https://github.com/LuminFire/Give-Stripe/" target="_blank">Give Stripe</a> plugin installed and activated for the Apple Pay Add-on to activate.', 'giveapplepay' ) . '</p></div>';
}


/**
 * Notice for min. version violation.
 *
 * @since 0.0.1
 */
function give_apple_pay_version_notice() {
	echo '<div class="error"><p>' . sprintf( __( '<strong>Activation Error:</strong> You must have <a href="https://givewp.com/" target="_blank">Give</a> version %s+ for the Apple Pay Add-on to activate.', 'giveapplepay' ), GIVE_APPLE_PAY_MIN_GIVE_VER ) . '</p></div>';
}


/**
 * Give Apple Pay activation banner
 *
 * Includes and initializes Give activation banner class.
 *
 * @since 0.0.1
 */
function give_apple_pay_activation_banner() {

	if ( ! class_exists( 'Give_Addon_Activation_Banner' )
	     && file_exists( GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php' ) ) {
		include GIVE_PLUGIN_DIR . 'includes/admin/class-addon-activation-banner.php';
	}

	if ( class_exists( 'Give_Addon_Activation_Banner' ) ) {

		$args = [
			'file'              => __FILE__,
			'name'              => esc_html__( 'Apple Pay Gateway', 'giveapplepay' ),
			'version'           => GIVE_APPLE_PAY_VERSION,
			'settings_url'      => admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=gateways&section=apple-pay-settings' ),
			'documentation_url' => 'https://luminfire.com/#',
			'support_url'       => 'https://luminfire.com/#',
			'testing'           => false,
		];

		new Give_Addon_Activation_Banner( $args );

	}

	return true;
}


/**
 * Deactivate Give Apple Pay and show the right admin notification
 *
 * @since 0.0.1
 *
 * @param string $notice      | Activation error notice
 * @param string $plugin_name | The plugin were deactivating
 */
function give_apple_pay_deactivate_plugin( $notice, $plugin_name ) {
	add_action( 'admin_notices', $notice );

	deactivate_plugins( $plugin_name );

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}


add_filter( 'plugin_action_links_' . GIVE_APPLE_PAY_BASENAME, 'give_apple_pay_plugin_action_links' );
/**
 * Plugins row action links
 *
 * @since 0.0.1
 *
 * @param array $actions An array of plugin action links.
 *
 * @return array An array of updated action links.
 */
function give_apple_pay_plugin_action_links( $actions ) {
	$new_actions = [
		'settings' => sprintf(
			'<a href="%1$s">%2$s</a>',
			admin_url( 'edit.php?post_type=give_forms&page=give-settings&tab=addons' ),
			esc_html__( 'Settings', 'giveapplepay' )
		),
	];

	return array_merge( $new_actions, $actions );
}





add_filter( 'plugin_row_meta', 'give_apple_pay_plugin_row_meta', 10, 2 );
/**
 * Plugin row meta links.
 *
 * @since 0.0.1
 *
 * @param array  $plugin_meta An array of the plugin's metadata.
 * @param string $plugin_file Path to the plugin file, relative to the plugins directory.
 *
 * @return array
 */
function give_apple_pay_plugin_row_meta( $plugin_meta, $plugin_file ) {
	if ( GIVE_APPLE_PAY_BASENAME !== $plugin_file ) {
		return $plugin_meta;
	}

	$new_meta_links = [
		sprintf(
			'<a href="%1$s" target="_blank">%2$s</a>',
			esc_url( add_query_arg( [
					'utm_source'   => 'plugins-page',
					'utm_medium'   => 'plugin-row',
					'utm_campaign' => 'admin',
				], 'https://luminfire.com/#' )
			),
			esc_html__( 'Documentation', 'giveapplepay' )
		),
	];

	return array_merge( $plugin_meta, $new_meta_links );
}

