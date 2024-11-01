<?php
/**
 * Simplified dashboard and gateway to the SASS Xelation service
 *
 * @package Xelation
 *
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path( __FILE__ ) . '/classes/class-wp-key-manager.php';
require_once plugin_dir_path( __FILE__ ) . '/classes/class-wp-xelation-surface.php';
require_once plugin_dir_path( __FILE__ ) . '/classes/class-wp-xelation-dependency-service.php';

require_once plugin_dir_path( __FILE__ ) . '../inc/functions.php';
require_once plugin_dir_path( __FILE__ ) . '../inc/plugin-status.php';


// Check dependencies
$xelation_dependency_service = new WP_Xelation_Dependency_Service();
if ( !empty( $xelation_dependency_service->has_valid_dependencies() ) ) {
    return;
}

$xelation_domain = 'https://xelation.org';
$xelation_woo_domain = get_bloginfo( 'wpurl' );
$xelation_authorization_url = esc_url_raw( $xelation_domain . '/xero/authorization?purpose=plugin&domain=' . $xelation_woo_domain );

// Get xelation plugin status.
$xelation_surface = new Xelation_Surface();
$xelation_org_detail = $xelation_surface->xelation_plugin_status( $xelation_authorization_url );

// Check if we already have a woo rest api record.
$xelation_key_manager = new Xelation_Key_Manager();
//$xelation_keys = $xelation_key_manager->delete_api_keys();
$xelation_keys = $xelation_key_manager->get_api_keys();

// Check for pre-existing woo api keys
if ( ! isset( $xelation_keys ) ) {
    // First timer so so generate woo api keys rom xelation endpoint.
	$xelation_keys_enc = $xelation_surface->xelation_generate_keys( $xelation_woo_domain );

	$xelation_keys = explode( ',', $xelation_key_manager->encrypt_decrypt( 'decrypt', $xelation_keys_enc ) );

	$xelation_key_manager->insert_api_keys( $xelation_keys[1], $xelation_keys[2] );
}
?>
<div id="xelation-panel"></div>
