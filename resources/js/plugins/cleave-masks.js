import Cleave from 'cleave.js';

let cleaveMasks = {

    cleave: null,

    type: {
        phone: '[data-role="js-mask-phone"]',
        phoneint: '[data-role="js-mask-phone-int"]',
        int: '[data-role="js-mask-int"]',
        price: '[data-role="js-mask-price"]'
    },

    integer: function (target) {
        this.cleave = new Cleave(target, {
            blocks: [11],
            numericOnly: true
        });
    },
    phone: function (target) {
        this.cleave = new Cleave(target, {
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
$('body').on('focus', cleaveMasks.type.phone, function () {
    cleaveMasks.phone($(this));
}).on('focusout', cleaveMasks.type.phone, function () {
    if ($(this).val().length !== 18) {
        $(this).val('');
    }
});
