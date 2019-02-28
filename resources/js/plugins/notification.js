/*
 * @copyright Copyright (c) 2018-2019 "ИД Панорама"
 * @author Дмитрий Поскачей (dposkachei@gmail.com)
 */

/**
 * notification.send({
 *  type: 'error',
 *  title: 'Ошибка',
 *  text: 'Текст ошибки'
 * })
 *
 *
 * @type {{send(*): void}}
 */
window.notification = {
    send(notification) {
        switch (notification.type) {
            case 'warning':
                window.toastr.warning(notification.text, notification.title, notification.options);
                break;
            case 'success':
                window.toastr.success(notification.text, notification.title, notification.options);
                break;
            case 'error':
                window.toastr.error(notification.text, notification.title, notification.options);
                break;
            case 'info':
                window.toastr.info(notification.text, notification.title, notification.options);
                break;
            default:
                window.toastr.info(notification.text, notification.title, notification.options);
                break;
        }
    },
};
