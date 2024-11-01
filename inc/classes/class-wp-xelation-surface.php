<?php
/**
 * Xelation interface:  Xelation_Surface
 *
 * @package Xelation
 *
 * @since 1.0
 */

if ( ! class_exists( 'Xelation_Surface' ) ) {
	class Xelation_Surface {

		// Get xelation status from xelation endpoint.
		function xelation_plugin_status( $domain ) {
			global $xelation_domain;

			$url = esc_url( $xelation_domain . '/woo/plugin-status.php?domain=' . $domain );

            $response = wp_remote_get( $url );

            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                return false;
            }

			return $response['body'];
		}

		// Generate one-time woo keys from xelation endpoint.
		function xelation_generate_keys( $domain ) {
			global $xelation_domain;

			$url = esc_url( $xelation_domain . '/woo/plugin-generate-keys.php?domain=' .  $domain );

            $response = wp_remote_get( $url );

            if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
                return false;
            }

            return $response['body'];
		}
	}
}
