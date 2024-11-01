<?php
/**
 * @package Xelation
 *
 * @version 0.1
 */

/*
 * Plugin Name:       Xelation
 * Plugin URI:        http://xelation.org/plugin
 * Description:       Xelation seamlessly synchronises your Woo orders with Xero. Configure mappings for sales, shipping, transaction fees, payments and stock.
 * Version:           0.1.1
 * Requires at least: 5.0
 * Requires PHP:      7.0
 * Author:            Glide Digital Ltd
 * Author URI:        https://xelation.org
 * License:           GPL v2 or later
 * Text Domain:       xelation
 *
 * Copyright 2023-2024 Xelation
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path( __FILE__ ) . 'inc/functions.php';

$xelation_domain = 'https://xelation.org';

function xelation_styles() {
	global $xelation_domain;
	wp_enqueue_style( 'plugin_custom', $xelation_domain . '/common/css/plugin.min.css', array(), wp_rand(111,9999), 'all' );
}
add_action( 'admin_print_styles', 'xelation_styles' );
