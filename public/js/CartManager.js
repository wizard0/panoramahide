/**
 * Created by wizard on 11/30/18.
 */
(function (window, $) {
    if (!!window.JSCartManager) return;

    window.JSCartManager = function() {
        $(window.document).on('click', '.addToCart', this.addToCart);
    };

    window.JSCartManager.prototype.addToCart = function(event) {
        event.preventDefault;
        var version = $(this).data('version'),
            type = $(this).data('product-type'),
            id = $(this).data('id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: '/add-to-cart',
            data: {
                'version': version,
                'type': type,
                'id': id
            },
            success: function (res) {
                var newCart = $(res);
                $('#cart-in-header').replaceWith(newCart);
                alert('Товар успешно добавлен в корзину');
            }
        });
    };
})(window, jQuery)
