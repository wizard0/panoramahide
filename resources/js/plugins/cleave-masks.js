import Cleave from 'cleave.js';

let cleaveMasks = {

    cleave: null,

    type: {
        phone: '[data-role="js-mask-phone"]',
        phoneint: '[data-role="js-mask-phone-int"]',
        int: '[data-role="js-mask-int"]',
        price: '[data-role="js-mask-price"]'
    },

    integer: function ($target) {
        let self = this;
        self.cleave = new Cleave($target, {
            blocks: [$target.data('length') ? $target.data('length') : 2],
            numericOnly: true
        });
    },
    phone: function (target) {
        let self = this;
        let value = target.val();
        if (value.length === 11 && value.charAt(0) === '7') {
            target.val(window.HELPER.phoneFormat(value));
        }
        self.cleave = new Cleave(target, {
            prefix: '+7',
            blocks: [2, 0, 3, 0, 3, 2, 2],
            delimiters: [' ', '(', ')', ' ', '-', '-'],
            numericOnly: true
        });
    },
};

if ($(cleaveMasks.type.phone).is(':focus')) {
    cleaveMasks.phone($(cleaveMasks.type.phone));
}
if ($(cleaveMasks.type.phone).length) {
    $(cleaveMasks.type.phone).each(function () {
        cleaveMasks.phone($(this));
    });
}
$('body').on('focus', cleaveMasks.type.phone, function () {
    cleaveMasks.phone($(this));
}).on('focusout', cleaveMasks.type.phone, function () {
    if ($(this).val().length !== 18) {
        $(this).val('');
    }
});
if ($(cleaveMasks.type.int).length) {
    $(cleaveMasks.type.int).each(function () {
        cleaveMasks.integer($(this));
    });
}
