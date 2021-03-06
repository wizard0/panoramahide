/**
 * После отправки формы на Получить доступ по промокоду
 *
 * @param result
 * @param $form
 */
window['after-callbackPromoAccess'] = function (result, $form) {
    console.log(result, $form);
    if (result.result === 1) {
        let $modal = $('#promo-code-modal');
        $modal.find('.help').remove();
        $modal.find('input.is-danger').removeClass('is-danger');
        $modal.find('input').val('');
        $modal.modal('show');
    }
    if (result.result === 2) {
        $('#promo-access-password-modal').modal('show');
        $('#promo-access-password-modal').find('input[name="email"]').val($form.find('input[name="email"]').val());
    }
    if (result.result === 3) {
        let $modal = $('#promo-activation-promocode-modal');
        $('.modal').modal('hide');
        $modal.modal('show');
        $modal.find('form').submit();
    }
};

/**
 * После отправки формы на Получить доступ по промокоду
 *
 * @param result
 * @param $form
 */
window['after-callbackReaderAccess'] = function (result, $form) {
    // Код успешно подтвержден
    if (result.result === 3) {
        $('.modal').modal('hide');
    }
    // Устройство успешно подтверждено
    if (result.result === 4) {
        $('.modal').modal('hide');
    }
    // Ссылка успешно отправлена
    if (result.result === 5) {

    }
};

/**
 * Закрытие модального окна
 *
 * @param result
 * @param $form
 */
window['after-closeModal'] = function (result, $form) {
    $form.closest('.modal').modal('hide');
};

/**
 * Закрытие модального окна
 *
 * @param result
 * @param $form
 */
window['after-showMessageLoading'] = function (result, $form) {
    if (!result.success) {
        let $messageContainer = $form.find('.message-loading');
        $messageContainer.html(result.message);
        $messageContainer.removeClass('is-loading');
        $messageContainer.addClass('__is-danger');
    }
};

/**
 * Обновление корзины после удаления
 *
 * @param result
 * @param $form
 */
window['after-cartDeleteItem'] = function (result, $form) {
    console.log('after-cartDeleteItem');
    if (result.success) {
        $('#cart-in-header').replaceWith(result.header);
        $('#personal-cart-content').replaceWith(result.cart);
    }
};
