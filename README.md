# Nafizul Islam (Noyon)

# Custom WooCommerce Product Variation Display

Enhance WooCommerce product page with an interactive variation display feature for T-shirt color and size options.

## Setup and Usage

1. **Clone the Repository:**

    Clone this repository to local environment or download and extract the ZIP archive.

    ```sh
    git clone https://github.com/username/woocommerce-variation-display.git
    ```

2. **Upload Files:**

    - Upload `custom-variation-display.php` to WordPress plugins directory (`wp-content/plugins`).
    - Upload `css/custom-variation-display.css` to WordPress theme's CSS directory (`wp-content/themes/theme/css`).
    - Upload `js/custom-variation-display.js` to WordPress theme's JavaScript directory (`wp-content/themes/theme/js`).
    - Ensure you have the T-shirt images (`blue-shirt.jpg`, `green-shirt.jpg`, `red-shirt.jpg`) in an `images` directory at the root of project.

3. **Activate Plugin:**

    Log in to WordPress admin panel, navigate to the "Plugins" section, and activate the "Custom WooCommerce Variation Display" plugin.

4. **Configure the Settings:**

    Go to WooCommerce > Settings > Products > Custom Variation Display. Enable or disable the custom variation display feature as needed.

5. **Integrate Code:**

    - Add the provided PHP code from `custom-variation-display.php` to the relevant WooCommerce product template where you want the feature to appear.
    - Enqueue the provided CSS and JavaScript files in WordPress theme, using the functions `wp_enqueue_style` and `wp_enqueue_script` respectively.

6. **Run Project:**

    Load the WooCommerce product pages and experience the enhanced variation display feature. Select different colors and sizes to update the product image and dynamic price.

## Compatibility

This plugin follows best practices to ensure compatibility with other plugins and themes. However, consider testing on specific WordPress environment.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
