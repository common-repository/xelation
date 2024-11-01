<?php
/**
 * Common functions required plugin-wide
 *
 * @package Xelation
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Hook the 'admin_menu' action hook adding new menu to the wp admin dashboard.
add_action( 'admin_menu', 'xelation_add_admin_link' );
if ( ! function_exists( 'xelation_add_admin_link' ) ) {
	function xelation_add_admin_link() {
		// Target options page: 'manage_options'.
		add_options_page(
            __( 'Xelation', 'xelation' ),
            __( 'Xelation', 'xelation' ),
            'manage_options',
            'xelation/inc/gateway.php'
        );
	}
}

add_filter( 'plugin_action_links', 'xelation_add_plugin_link', 10, 2 );
if ( ! function_exists( 'xelation_add_plugin_link' ) ) {
	function xelation_add_plugin_link( $plugin_actions, $plugin_file ) {
		$new_actions = array();
        $url = esc_url_raw( admin_url( 'admin.php?page=xelation/inc/gateway.php' ) );

        if ( 'xelation/xelation.php' === $plugin_file ) {
            $new_actions['xelation_settings'] = '<a href="' . $url . '">' . __('Settings', 'xelation') . '</a>';
        }
        return array_merge( $new_actions, $plugin_actions );
	}
}