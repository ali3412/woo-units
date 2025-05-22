# WooCommerce Units Display

A simple WordPress plugin that displays product units before the quantity selector on WooCommerce product pages.

## Description

This plugin adds the ability to display a unit of measurement (like kg, pcs, liters, etc.) before the quantity selector on WooCommerce product pages. The unit is pulled from a custom field called 'unit' that you can set for each product.

## Installation

1. Upload the `woo-units` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to your WooCommerce product edit page
4. In the Product Data section, add a custom field named 'unit' with your desired unit value (e.g., "kg", "pcs", "liters")

## Usage

1. Edit a WooCommerce product
2. Scroll down to the "Product data" section
3. Click on the "Custom Fields" tab (enable it from Screen Options if not visible)
4. Add a new custom field:
   - Name: `unit`
   - Value: Your desired unit (e.g., "kg", "pcs", "liters")
5. Update the product

The unit will now be displayed above the quantity selector on the single product page.

## Requirements

- WordPress 5.2 or higher
- WooCommerce 4.0 or higher
- PHP 7.2 or higher

## Changelog

### 1.0.0
* Initial release
