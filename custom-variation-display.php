
<?php
/*
Plugin Name: Custom Variation Display
Description: Enhances WooCommerce product page with color swatches and size selection.
Version: 1.0
Author: Your Name
*/

// Enqueue scripts and styles
function cvd_enqueue_scripts() {
    if (is_product()) {
        wp_enqueue_script('custom-variation-display', plugin_dir_url(__FILE__) . 'js/custom-variation-display.js', array('jquery'), '1.0', true);
        wp_enqueue_style('custom-variation-display', plugin_dir_url(__FILE__) . 'css/custom-variation-display.css');
    }
}
add_action('wp_enqueue_scripts', 'cvd_enqueue_scripts');
