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
        // Hook to display unit in cart
        add_filter('woocommerce_cart_item_name', array($this, 'display_unit_in_cart'), 10, 3);
        
        // Enqueue styles and scripts
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        
        // AJAX handlers
        add_action('wp_ajax_get_unit_title', array($this, 'get_unit_title_ajax'));
        add_action('wp_ajax_nopriv_get_unit_title', array($this, 'get_unit_title_ajax'));
    }
    
    /**
     * Enqueue plugin styles and scripts
     */
    public function enqueue_scripts() {
        // Enqueue on both product pages and cart pages
        if (is_product() || is_cart()) {
            wp_enqueue_style('woo-units-style', plugins_url('assets/css/woo-units.css', __FILE__), array(), '1.0.0');
            
            // Enqueue JavaScript только на странице товара
            if (is_product()) {
                wp_enqueue_script('woo-units-script', plugins_url('assets/js/woo-units.js', __FILE__), array('jquery'), '1.0.0', true);
                
                // Передаем параметры в JavaScript
                wp_localize_script('woo-units-script', 'woo_units_params', array(
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('woo_units_nonce')
                ));
            }
        }
    }

    /**
     * AJAX callback to get unit_title
     */
    public function get_unit_title_ajax() {
        // Проверяем nonce для безопасности
        check_ajax_referer('woo_units_nonce', 'nonce');
        
        $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
        $response = array('success' => false);
        
        if ($product_id > 0) {
            // Получаем значение unit_title
            $unit_title = get_post_meta($product_id, 'unit_title', true);
            
            if (!empty($unit_title)) {
                $response = array(
                    'success' => true,
                    'data' => array(
                        'unit_title' => esc_html($unit_title)
                    )
                );
            }
        }
        
        wp_send_json($response);
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
