/**
 * Created by wizard on 11/30/18.
 */
(function (window, $) {
    if (!!window.JSCartManager) return;

    window.JSCartManager = function () {
        $(window.document).on('click', '.addToCart', $.proxy(this.processAddToCart, this));
        $(window.document).on('click', '.deleteFromCart', $.proxy(this.deleteFromCart, this));

    };

    window.JSCartManager.prototype.processByModal = function (event) {
        event.preventDefault();
        console.log('coming in');
        var version = $(event.target).find('input[name="version"]'),
            type = 'release',
            id = $(event.target).find('input[name="id"]');

        $.proxy(this.addToCart(version, type, id, 1), this);

        return false;
    }

    window.JSCartManager.prototype.processAddToCart = function (event) {
        event.preventDefault;
        var version = $(event.target).data('version'),
            type = $(event.target).data('product-type'),
            id = $(event.target).data('id');

        $.proxy(this.addToCart(version, type, id, 1), this);
        return false;
    };

    window.JSCartManager.prototype.addToCart = function (version, type, id, quantity, additionalData) {
        if (typeof additionalData == 'undefined')
            additionalData = null;
        this.sendRequest('/add-to-cart', {
            'version': version,
            'type': type,
            'id': id,
            'quantity': quantity,
            'additionalData': additionalData
        }, 'Товар успешно добавлен в корзину');
    }

    window.JSCartManager.prototype.deleteFromCart = function (event) {
        event.preventDefault();
        var item = $(event.target).parents('.cartItem'),
            type = item.data('type'),
            id = item.data('id');

        $.proxy(
            this.sendRequest('/delete-from-cart', {
                'type': type,
                'id': id
            }, 'Товар типа ' + type + ' id ' + id + ' успешно удален из корзины'),
            this);
    };

    window.JSCartManager.prototype.sendRequest = function (url, data, message) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            url: url,
            data: data,
            success: function (res) {
                var newCart = $(res);
                $('#cart-in-header').replaceWith(newCart);
                alert(message);
            }
        });
    }
})(window, jQuery)
