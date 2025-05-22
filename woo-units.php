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
        // Hook to display unit_title before variation add to cart section
        add_action('woocommerce_before_variations_form', array($this, 'display_unit_title_before_variations'));
        
        // Hook to display unit in cart
        add_filter('woocommerce_cart_item_name', array($this, 'display_unit_in_cart'), 10, 3);
        
        // Enqueue styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_styles'));
    }
    
    /**
     * Enqueue plugin styles
     */
    public function enqueue_styles() {
        // Enqueue on both product pages and cart pages
        if (is_product() || is_cart()) {
            wp_enqueue_style('woo-units-style', plugins_url('assets/css/woo-units.css', __FILE__), array(), '1.0.0');
        }
    }

    /**
     * Display unit_title before variations form
     */
    public function display_unit_title_before_variations() {
        global $product;
        
        // Get unit_title value from custom field
        $unit_title = get_post_meta($product->get_id(), 'unit_title', true);
        
        // Only display if unit_title is set
        if (!empty($unit_title)) {
            echo '<div class="unit-title-before-variations">' . esc_html($unit_title) . '</div>';
        }
    }
    
    /**
     * Display unit in cart
     */
    public function display_unit_in_cart($product_name, $cart_item, $cart_item_key) {
        // Check if we're on cart page
        if (!is_cart()) {
            return $product_name;
        }
        
        // Get product ID
        $product_id = $cart_item['product_id'];
        
        // Get unit value from custom field
        $unit = get_post_meta($product_id, 'unit', true);
        
        // Only display if unit is set
        if (!empty($unit)) {
            $product_name .= '<div class="product-unit">' . esc_html($unit) . '</div>';
        }
        
        return $product_name;
    }
}

// Initialize the plugin
new Woo_Units_Display();
