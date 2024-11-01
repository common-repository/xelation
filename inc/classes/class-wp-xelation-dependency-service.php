<?php
/**
 * WP_Xelation_Dependency_Service class
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Validates dependencies (core, plugins, versions) for Xelation
 * Used in the plugin main class for validation.
 */
class WP_Xelation_Dependency_Service {

	const WOOCORE_NOT_FOUND     = 'woocore_disabled';
	const WOOCORE_INCOMPATIBLE  = 'woocore_outdated';
	const WOOADMIN_NOT_FOUND    = 'wc_admin_not_found';
	const WOOADMIN_INCOMPATIBLE = 'wc_admin_outdated';
	const WP_INCOMPATIBLE       = 'wp_outdated';
	const DEV_ASSETS_NOT_BUILT  = 'dev_assets_not_built';

	/**
	 * Constructor.
	 */
	public function __construct() {

        self::display_admin_notices();
	}

	/**
	 * Checks if all the dependencies needed to run Xelation are present
	 *
	 * @return bool True if all required dependencies are met.
	 */
	public function has_valid_dependencies() {

		return $this->get_invalid_dependencies();
	}

	/**
	 * Render admin notices for unmet dependencies. Called on the admin_notices hook.
	 *
	 * @return null.
	 */
	public function display_admin_notices() {

		$invalid_dependencies = $this->get_invalid_dependencies();

		if ( ! empty( $invalid_dependencies ) ) {
            self::display_admin_error( $this->get_notice_for_invalid_dependency( $invalid_dependencies[0] ) );
		}
	}

    /**
     * Prints the given message in an "admin notice" wrapper with "error" class.
     *
     * @param string $message Message to print. Can contain HTML.
     */
    public static function display_admin_error( $message ) {
        self::display_admin_notice( $message, 'notice-error' );
    }

    /**
     * Prints the given message in an "admin notice" wrapper with provided classes.
     *
     * @param string $message Message to print. Can contain HTML.
     * @param string $classes Space separated list of classes to be applied to notice element.
     */
    public static function display_admin_notice( $message, $classes ) {
        ?>
        <div class="notice <?php echo esc_attr( $classes ); ?>">
            <p><b><?php echo esc_html( __( 'Xelation', 'xelation' ) ); ?></b></p>
            <p><?php echo $message; // PHPCS:Ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
        </div>
        <?php
    }

	/**
	 * Returns an array of invalid dependencies
	 *
	 * @return array of invalid dependencies as string constants.
	 */
	public function get_invalid_dependencies() {

		$invalid_dependencies = [];

		// Either ignore the account connection check or check if there's a cached account connection.
		//$ignore_when_account_is_connected = $check_account_connection && $this->has_cached_account_connection();

		if ( ! $this->is_woo_core_active() ) {
			$invalid_dependencies[] = self::WOOCORE_NOT_FOUND;
		}

/*		if ( ! $this->is_woo_core_version_compatible() ) {
			$invalid_dependencies[] = self::WOOCORE_INCOMPATIBLE;
		}*/

		if ( ! $this->is_wc_admin_enabled() ) {
			$invalid_dependencies[] = self::WOOADMIN_NOT_FOUND;
		}

/*		if ( ! $this->is_wc_admin_version_compatible() ) {
			$invalid_dependencies[] = self::WOOADMIN_INCOMPATIBLE;
		}

		if ( ! $this->is_wp_version_compatible() ) {
			$invalid_dependencies[] = self::WP_INCOMPATIBLE;
		}*/

		return $invalid_dependencies;

	}

	/**
	 * Checks if WooCommerce is installed and activated.
	 *
	 * @return bool True if WooCommerce is installed and activated.
	 */
	public function is_woo_core_active() {
		// Check if WooCommerce is installed and active.
		return class_exists( 'WooCommerce' );
	}

	/**
	 * Get the error constant of an invalid dependency, and transforms it into HTML to be used in an Admin Notice.
	 *
	 * @param string $code - invalid dependency constant.
	 *
	 * @return string HTML to render admin notice for the unmet dependency.
	 */
	private function get_notice_for_invalid_dependency( $code ) {

		$error_message = '';

		switch ( $code ) {
			case self::WOOCORE_NOT_FOUND:

                $error_message =  'Xelation requires <a>WooCommerce</a> to be installed and active.';

				if ( current_user_can( 'install_plugins' ) ) {
					if ( is_wp_error( validate_plugin( 'woocommerce/woocommerce.php' ) ) ) {
						// WooCommerce is not installed.
						$activate_url  = wp_nonce_url( admin_url( 'update.php?action=install-plugin&plugin=woocommerce' ), 'install-plugin_woocommerce' );
						$activate_text = __( 'Install WooCommerce', 'xelation' );
					} else {
						// WooCommerce is installed, so it just needs to be enabled.
						$activate_url  = wp_nonce_url( admin_url( 'plugins.php?action=activate&plugin=woocommerce/woocommerce.php' ), 'activate-plugin_woocommerce/woocommerce.php' );
						$activate_text = __( 'Activate WooCommerce', 'xelation' );
					}
					$error_message .= ' <a href="' . $activate_url . '">' . $activate_text . '</a>';
				}

				break;
		}

		return $error_message;
	}

    /**
     * Checks if the WooCommerce version has WooCommerce Admin bundled (WC 4.0+)
     * but it's disabled using a filter.
     *
     * @return bool True if WC Admin is found
     */
    public function is_wc_admin_enabled() {

        // Check if the current WooCommerce version has WooCommerce Admin bundled (WC 4.0+) but it's disabled using a filter.
        if ( ! defined( 'WC_ADMIN_VERSION_NUMBER' ) || apply_filters( 'woocommerce_admin_disabled', false ) ) {
            return false;
        }

        return true;
    }

	/**
	 * Checks if current page is plugin installation process page.
	 *
	 * @return bool True when installing plugin.
	 */
	private static function is_at_plugin_install_page() {
		$cur_screen = get_current_screen();
		return $cur_screen && 'update' === $cur_screen->id && 'plugins' === $cur_screen->parent_base;
	}
}
