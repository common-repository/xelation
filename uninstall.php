<?php
// if uninstall.php is not called by WordPress, die
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
}

require_once plugin_dir_path( __FILE__ ) . '/inc/classes/class-wp-key-manager.php';
require_once plugin_dir_path( __FILE__ ) . '/inc/functions.php';

// Delete woo rest api record.
$xelation_key_manager = new Xelation_Key_Manager();
$xelation_key_manager->delete_api_keys();
?>