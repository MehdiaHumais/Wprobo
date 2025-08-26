<?php
/**
 * Plugin Name: WPRobo Quantity Rules for WooCommerce
 * Description: Min/Max/Step quantity rules per product, category, or globally.
 * Version: 0.1.0
 * Author: WPRobo
 * Text Domain: wprobo-quantity-rules
 */

if ( ! defined( 'ABSPATH' ) ) exit;


error_reporting(E_ALL);
ini_set('display_errors', 1);


define( 'WPRQR_FILE', __FILE__ );
define( 'WPRQR_DIR', plugin_dir_path( __FILE__ ) );
define( 'WPRQR_URL', plugin_dir_url( __FILE__ ) );
define( 'WPRQR_VERSION', '0.1.0' );


if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
    require_once __DIR__ . '/vendor/autoload.php';
} else {
    add_action('admin_notices', function () {
        echo '<div class="notice notice-error"><p>'
             . __('WPRobo Quantity Rules: <code>vendor/autoload.php</code> is missing. Run <code>composer dump-autoload</code>.', 'wprobo-quantity-rules')
             . '</p></div>';
    });
    return;
}


register_activation_hook( __FILE__, function() {
    if ( class_exists( '\WPRobo\QuantityRules\Install\Activator' ) ) {
        ( new \WPRobo\QuantityRules\Install\Activator() )->run();
    }
});


register_deactivation_hook( __FILE__, function() {
    if ( class_exists( '\WPRobo\QuantityRules\Install\Deactivator' ) ) {
        ( new \WPRobo\QuantityRules\Install\Deactivator() )->run();
    }
});


add_action( 'plugins_loaded', function() {
    if ( ! class_exists( 'WooCommerce' ) ) {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p>'
                . esc_html__( 'WPRobo Quantity Rules requires WooCommerce to be active.', 'wprobo-quantity-rules' )
                . '</p></div>';
        });
        return;
    }

    if ( class_exists( '\WPRobo\QuantityRules\Plugin' ) ) {
        ( new \WPRobo\QuantityRules\Plugin() )->boot();
    } else {
        add_action( 'admin_notices', function() {
            echo '<div class="notice notice-error"><p>'
                . __('WPRobo Quantity Rules: <code>Plugin</code> class not found in <code>src/Plugin.php</code>.', 'wprobo-quantity-rules')
                . '</p></div>';
        });
    }
});
