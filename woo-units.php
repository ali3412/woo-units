<?php
/**
 * Plugin Name: WooCommerce Units Display
 * Description: Отображает значение произвольного поля "unit" перед полем выбора количества на странице товара WooCommerce
 * Version: 1.0.0
 * Author: Danil Trubicyn
 * Text Domain: woo-units
 * Domain Path: /languages
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * WC requires at least: 4.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Check if WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    return;
}

/**
 * Main plugin class
 */
class Woo_Units_Display {

    /**
     * Constructor
     */
    public function __construct() {
        // Hook to display unit before quantity input
        add_action('woocommerce_before_add_to_cart_quantity', array($this, 'display_unit_before_quantity'));
        
        // Enqueue styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }
    
    /**
     * Enqueue plugin styles
     */
    public function enqueue_styles() {
        // Only enqueue on single product pages
        if (is_product()) {
            wp_enqueue_style('woo-units-style', plugins_url('assets/css/woo-units.css', __FILE__), array(), '1.0.0');
        }
    }

    /**
     * Display unit value before quantity input
     */
    public function display_unit_before_quantity() {
        global $product;
        
        // Get unit value from custom field
        $unit = get_post_meta($product->get_id(), 'unit', true);
        
        // Only display if unit is set
        if (!empty($unit)) {
            echo '<div class="product-unit">' . esc_html($unit) . '</div>';
        }
    }
}

// Initialize the plugin
new Woo_Units_Display();