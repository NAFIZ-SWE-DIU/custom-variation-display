jQuery(document).ready(function($) {
    // Color Swatch Click Event
    $('.color-swatch').on('click', function() {
        var selectedColor = $(this).data('color');
        var selectedImage = 'path/to/your/images/' + selectedColor + '-shirt.jpg'; // Adjust the path
        
        $('.color-swatch').removeClass('selected');
        $(this).addClass('selected');
        
        $('.product-image img').attr('src', selectedImage);
        $('.product-image img').attr('alt', selectedColor + ' T-shirt'); // Optional: Update alt attribute
        
        updateDynamicPrice(selectedColor);
    });
    
    // Size Selection
    $('.size-selection select').on('change', function() {
        var selectedSize = $(this).val();
        $(this).find('option').removeClass('selected');
        $(this).find('option[value="' + selectedSize + '"]').addClass('selected');
        
        var selectedColor = $('.color-swatch.selected').data('color');
        
        updateDynamicPrice(selectedColor);
    });

    // Function to update dynamic price
    function updateDynamicPrice(selectedColor) {
        var selectedSize = $('.size-selection select').val();
        var matchingVariation = customVariations.find(function(variation) {
            return variation.attributes.attribute_pa_size === selectedSize &&
                   variation.attributes.attribute_pa_color === selectedColor;
        });

        if (matchingVariation) {
            var formattedPrice = accounting.formatMoney(matchingVariation.display_price, {
                symbol: customVariations.currency_symbol,
                thousand: customVariations.thousand_separator,
                decimal: customVariations.decimal_separator
            });

            $('.dynamic-price').text(formattedPrice);
        }
    }
});
