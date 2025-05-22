<?php
/**
 * Plugin Name: WooCommerce Units Display
 * Description: Displays product unit before quantity selector on product pages
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: woo-units
 * Domain Path: /languages
 * Requires at least: 5.2
 * Requires PHP: 7.2
 * WC requires at least: 4.0
 * WC tested up to: 7.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Woo_Units_Display {

    /**
     * Constructor
     */
    public function __construct() {
        // Display unit before quantity
        add_action('woocommerce_before_add_to_cart_quantity', array($this, 'display_unit_before_quantity'), 10);
    }

    /**
     * Display unit before quantity selector
     */
    public function display_unit_before_quantity() {
        global $product;
        
        // Get the unit value from product meta
        $unit = get_post_meta($product->get_id(), 'unit', true);
        
        // If unit exists, display it
        if (!empty($unit)) {
            echo '<div class="product-unit" style="margin-bottom: 10px; font-weight: bold;">';
            echo esc_html($unit);
            echo '</div>';
        }
    }
}

// Initialize the plugin
new Woo_Units_Display();
