/**
 * После отправки формы на Получить доступ по промокоду
 *
 * @param result
 * @param $form
 */
window['after-callbackPromoAccess'] = function (result, $form) {
    console.log(result, $form);
    if (result.result === 1) {
        $('#code-modal').modal('show');
    }
    if (result.result === 2) {
        $('#promo-access-password-modal').modal('show');
        $('#promo-access-password-modal').find('input[name="email"]').val($form.find('input[name="email"]').val());
    }
};
