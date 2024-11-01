<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

require_once plugin_dir_path( __FILE__ ) . '../inc/classes/class-wp-key-manager.php';
require_once plugin_dir_path( __FILE__ ) . '../inc/functions.php';

// Panel refresh activated by default
$panel_refresh = 1;
if ( isset( $_GET['panel-refresh'] ) ) {
	$panel_refresh = sanitize_text_field( $_GET['panel-refresh'] );

    // Validate: numeric values only please.
    if(is_numeric($panel_refresh)) {
        // Validate: force binary value.
        if ($panel_refresh == 0) {
            $panel_refresh = 0;
        }
    }
}

// Check for pre-existing woocommerce api keys
$xelation_key_manager = new Xelation_Key_Manager();
$xelation_keys = $xelation_key_manager->get_api_keys();

// Keys inactive by default
$keys_active = 1;
// Validate: object only please.
if ( !is_object( $xelation_keys ) ) {
    $keys_active = 0;
}

// Generate url of the server-side script
$domain = 'https://xelation.org';
$blogUrl = get_bloginfo( 'wpurl' );
$pluginListenerUrl = $domain . '/woo/plugin-status-listen.php?domain=' . $blogUrl;
?>
<script>
	jQuery(document).ready(function(){
        xelation_listen(1); // Fire listener immediately.

        const refreshInterval = 5000;  // 5 seconds
        const refreshTimeout = 900000; // 15 minutes

        var panelRefresh = '<?php echo esc_html( sanitize_text_field( $panel_refresh ) ); ?>';

        if(panelRefresh == 1) { // Listen at subsequent intervals.
            var myTimer = setInterval(function () {
                xelation_listen(1);
            }, refreshInterval); // Refresh content.
        }

        // Terminate listener following refreshTimeout.
        setTimeout(() => { clearInterval(myTimer); xelation_listen(0); }, refreshTimeout);
	});

    function xelation_listen( $status ){
        var pluginListenerUrl = "<?php echo( esc_url( $pluginListenerUrl ) ); ?>";
        var keysActive = "<?php echo( esc_html( $keys_active ) ); ?>";
        var pluginListenerUrlStatus = pluginListenerUrl + '&keys_active=' + keysActive + '&refresh=' + $status;

        jQuery.ajax({
            url: pluginListenerUrlStatus,
            success: function(data) {
                jQuery('#xelation-panel').html(data); // Update the content of the div element
            }
        });
    }(jQuery)
</script>
