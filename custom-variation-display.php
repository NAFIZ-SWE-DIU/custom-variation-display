<?php
/*
Plugin Name: Custom Variation Display
Description: Enhances WooCommerce product page with custom variation display.
Version: 1.0
Author: Nafizul Islam
*/

// Enqueue styles and scripts
function custom_variation_display_enqueue_assets() {
    if (is_product()) {
        wp_enqueue_style('custom-variation-display', plugin_dir_url(__FILE__) . 'css/custom-variation-display.css', array(), '1.0');
        wp_enqueue_script('accounting', plugin_dir_url(__FILE__) . 'js/accounting.min.js', array(), '0.4.1', true); // Enqueue accounting.js
        wp_enqueue_script('custom-variation-display', plugin_dir_url(__FILE__) . 'js/custom-variation-display.js', array('jquery'), '1.0', true);
    }
}
add_action('wp_enqueue_scripts', 'custom_variation_display_enqueue_assets');





// Add color swatches
function custom_variation_display_color_swatches() {
    global $product;

    // Get available color variations
    $color_variations = $product->get_variation_attributes()['pa_color'];

    if (!empty($color_variations)) {
        echo '<div class="color-swatches">';
        
        foreach ($color_variations as $color_variation) {
            // Get the color name or value
            $color_name = get_term_by('slug', $color_variation, 'pa_color')->name;
            
            // Output color swatch
            echo '<div class="color-swatch" data-color="' . esc_attr($color_variation) . '">' . esc_html($color_name) . '</div>';
        }
        
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_variation_display_color_swatches');





// Modify product image on color swatch click
function custom_variation_display_change_image_on_color_click() {
    global $product;

    // Get available color variations
    $color_variations = $product->get_variation_attributes()['pa_color'];

    if (!empty($color_variations)) {
        ?>
        <script>
        jQuery(function($) {
            $('.color-swatch').on('click', function() {
                var selectedColor = $(this).data('color');
                var variationId = 0;

                // Find the corresponding variation ID based on the selected color
                $.each(<?php echo wp_json_encode($product->get_available_variations()); ?>, function(index, variation) {
                    if (variation.attributes.attribute_pa_color === selectedColor) {
                        variationId = variation.variation_id;
                        return false; // Exit the loop
                    }
                });

                // Change the main product image based on the selected color variation
                if (variationId > 0) {
                    var selectedColor = get_selected_color_from_variation_id(variationId); // Implement a function to get the color based on variation ID
                    var selectedImage = 'path/to/images/' + selectedColor + '-shirt.jpg'; // Adjust the path
                    
                    $('.product .woocommerce-product-gallery__image img').attr('src', selectedImage);
                }

            });
        });
        </script>
        <?php
    }
}
add_action('woocommerce_after_add_to_cart_button', 'custom_variation_display_change_image_on_color_click');





// Add size selection dropdown
function custom_variation_display_size_selection() {
    global $product;

    // Get available size variations
    $size_variations = $product->get_variation_attributes()['pa_size'];

    if (!empty($size_variations)) {
        echo '<div class="size-selection">';
        echo '<label for="size-dropdown">' . esc_html__('Select Size:', 'text-domain') . '</label>';
        echo '<select id="size-dropdown" name="size">';
        
        foreach ($size_variations as $size_variation) {
            // Get the size name or value
            $size_name = get_term_by('slug', $size_variation, 'pa_size')->name;
            
            echo '<option value="' . esc_attr($size_variation) . '">' . esc_html($size_name) . '</option>';
        }
        
        echo '</select>';
        echo '</div>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_variation_display_size_selection');





// Please note that the Below example requires the accounting.js library for formatting the price.
// Update dynamic price based on variation
function custom_variation_display_update_dynamic_price() {
    global $product;

    $variations = $product->get_available_variations();

    if (!empty($variations)) {
        ?>
        <script>
            jQuery(function($) {
                $('#size-dropdown').on('change', function() {
                    var selectedSize = $(this).val();
                    var selectedColor = $('.color-swatch.selected').data('color');
                    
                    // Find the matching variation
                    var matchingVariation = customVariations.find(function(variation) {
                        return variation.attributes.attribute_pa_size === selectedSize &&
                            variation.attributes.attribute_pa_color === selectedColor;
                    });

                    // Update the displayed price
                    if (matchingVariation) {
                        var formattedPrice = accounting.formatMoney(matchingVariation.display_price, {
                            symbol: customVariations.currency_symbol,
                            thousand: customVariations.thousand_separator,
                            decimal: customVariations.decimal_separator
                        });
                        $('.dynamic-price').text(formattedPrice);
                    }
                });
            });

        </script>
        <?php
    }
}
add_action('woocommerce_before_add_to_cart_button', 'custom_variation_display_update_dynamic_price');





// Add custom setting to WooCommerce settings page
function custom_variation_display_settings() {
    add_settings_section(
        'custom_variation_display_section', // Section ID
        __('Custom Variation Display', 'text-domain'), // Section title
        'custom_variation_display_section_callback', // Callback function
        'product' // Page where the section will be displayed
    );

    add_settings_field(
        'enable_custom_variation_display', // Field ID
        __('Enable Custom Variation Display', 'text-domain'), // Field title
        'enable_custom_variation_display_callback', // Callback function
        'product', // Page where the field will be displayed
        'custom_variation_display_section' // Section ID
    );

    // Register the settings
    register_setting('product', 'enable_custom_variation_display');
}

// Section callback
function custom_variation_display_section_callback() {
    echo '<p>' . __('Configure the custom variation display feature.', 'text-domain') . '</p>';
}

// Field callback
function enable_custom_variation_display_callback() {
    $option = get_option('enable_custom_variation_display');
    echo '<input type="checkbox" name="enable_custom_variation_display" value="1" ' . checked(1, $option, false) . '/>';
    echo '<label>' . __('Enable custom variation display', 'text-domain') . '</label>';
}
add_action('woocommerce_settings_tabs_product', 'custom_variation_display_settings');





// Initialize custom setting
function custom_variation_display_init_setting() {
    $option_name = 'enable_custom_variation_display';
    
    // Set a default value if the option is not set
    if (false === get_option($option_name)) {
        add_option($option_name, 0);
    }
}
add_action('woocommerce_init', 'custom_variation_display_init_setting');
