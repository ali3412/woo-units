jQuery(document).ready(function($) {
    // Функция для добавления unit_title перед .woocommerce-variation-add-to-cart
    function addUnitTitleBeforeVariationAddToCart() {
        // Получаем ID товара
        const productId = $('input[name="product_id"]').val() || $('input[name="variation_id"]').val() || $('form.cart').data('product_id');
        
        if (!productId) return;
        
        // Получаем значение unit_title через AJAX
        $.ajax({
            url: woo_units_params.ajax_url,
            type: 'POST',
            data: {
                action: 'get_unit_title',
                product_id: productId,
                nonce: woo_units_params.nonce
            },
            success: function(response) {
                if (response.success && response.data.unit_title) {
                    // Если элемент .unit-title-before-variations уже существует, обновляем его содержимое
                    if ($('.unit-title-before-variations').length) {
                        $('.unit-title-before-variations').html(response.data.unit_title);
                    } else {
                        // Иначе создаем новый элемент и вставляем его перед .woocommerce-variation-add-to-cart
                        $('.woocommerce-variation-add-to-cart').before('<div class="unit-title-before-variations">' + response.data.unit_title + '</div>');
                    }
                }
            }
        });
    }
    
    // Запускаем при загрузке страницы
    addUnitTitleBeforeVariationAddToCart();
    
    // Запускаем при изменении вариации
    $(document).on('found_variation', function() {
        addUnitTitleBeforeVariationAddToCart();
    });
    
    // Запускаем при сбросе вариации
    $(document).on('reset_data', function() {
        addUnitTitleBeforeVariationAddToCart();
    });
});
