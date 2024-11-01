<?php
/**
 * WooCommerce wpdb key interface:  Xelation_Key_Manager class
 *
 * @package Xelation
 *
 * @since 1.0
 */
if ( ! class_exists( 'Xelation_Key_Manager' ) ) {
	class Xelation_Key_Manager {

		// Check if we have pre-existing xelation api key.
		public function get_api_keys() {
			global $wpdb;

            $results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}woocommerce_api_keys WHERE description = 'Xelation' ORDER BY key_id DESC" );

            if ( $wpdb->last_error ) {
                //add_action( 'admin_notices', 'sample_admin_notice__error' );
                echo "<h2>Exception: Database table exception</h2><p>WooCommerce tables could not be found.</p><p>The WooCommerce plugin is a prerequisite for Xelation.</p><p>Please install WooCommerce.</p>";
                exit;
			} elseif ( null === $results ) {
				// First timer.
				return null;
			} else {
				// Return latest record although multiple records shouldn't be possible.
				return $results[0];
			}
		}

        // Insert xelation api key.
		public function insert_api_keys( $consumer_key, $consumer_secret ) {
			global $wpdb;
            $user_id  = 1;

			try {
				// Insert api keys directly into db.
				$wpdb->insert(
					$wpdb->prefix . 'woocommerce_api_keys',
					array(
						'user_id'         => $user_id,
						'description'     => 'Xelation',
						'permissions'     => 'read_write',
						'consumer_key'    => wc_api_hash( $consumer_key ),
						'consumer_secret' => $consumer_secret,
						'truncated_key'   => substr( $consumer_secret, -7 ),
					)
				);
			} catch ( Exception $e ) {
				$xelation_woo_domain = esc_url( get_bloginfo( 'wpurl' ) );
				$exception           = 'Exception: ' . $e->getMessage();
				$exception          .= '</br>Please contact <a href="mailto:info@xelation.org?subject=Xelation Plugin Exception&body=' . $exception . '%0D%0A%0D%0ADomain: ' . $xelation_woo_domain . '">info@xelation.org</a> quoting this error message.';
				echo esc_html( $exception );
			}
		}

        // Delete pre-existing xelation api key.
        public function delete_api_keys() {
            global $wpdb;
            $user_id  = 1;

            try {
				// Delete api keys.
				$wpdb->delete(
					$wpdb->prefix . 'woocommerce_api_keys',
					array(
						'user_id'         => $user_id,
						'description'     => 'Xelation',
						'permissions'     => 'read_write',
					)
				);

            } catch ( Exception $e ) {
                $xelation_woo_domain = esc_url( get_bloginfo( 'wpurl' ) );
                $exception           = 'Exception: ' . $e->getMessage();
                $exception          .= '</br>Please contact <a href="mailto:info@xelation.org?subject=Xelation Plugin Exception&body=' . $exception . '%0D%0A%0D%0ADomain: ' . $xelation_woo_domain . '">info@xelation.org</a> quoting this error message.';
                echo esc_html( $exception );
            }
        }

		// Function to encrypt/decrypt string.
		public function encrypt_decrypt( $action, $incoming_string ) {
			$output         = false;
			$encrypt_method = 'AES-256-CBC';
			$secret_key     = '"h=fc0BWo^{O4Y{{)&aX!uIp7o_saU';
			$secret_iv      = 'rYs^R[RMKJL9^M+!!;pq';
			$key            = hash( 'sha256', $secret_key );

			// Iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning.
			$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
			if ( $action === 'decrypt' ) {
				$output = openssl_decrypt( base64_decode( $incoming_string ), $encrypt_method, $key, 0, $iv );
			}
			return $output;
		}
	}
}
