$(document).ready(function() {

    deskbooksForm.initEvents();



});


const deskbooksForm = {
    current: 9,
    max: 5,
    $form: null,
    $checkboxes: null,
    button: {
        active: false,
    },

    initEvents() {
        const self = this;
        self.$form = $('.--journal-checkboxes');
        self.max = self.$form.data('max');
        self.setCurrent();
        self.setButtonActive();

        self.$form.find('.journal-checkbox input').each(function () {
            $(this).on('change', function () {
                let $item = $(this);
                if ($item.is(':checked')) {
                    if (!self.canSet()) {
                        $item.prop('checked', false);
                    }
                }
                self.setCurrent();
                self.setDisabled(self.current === self.max);
            });
        });
    },
    canSet() {
        const self = this;
        return self.current < self.max;
    },
    setDisabled(disabled) {
        const self = this;
        let $checkboxes = self.$form.find('.journal-checkbox input').not(':checked');
        if (disabled) {
            $checkboxes.prop('disabled', true);
        } else {
            $checkboxes.prop('disabled', false);
        }
        self.$form.parent().find('.inform').html(self.htmlCanSet());
    },
    setCurrent() {
        const self = this;
        self.current = self.$form.find('.journal-checkbox input:checked').length;
        self.setButtonActive();
    },
    setButtonActive() {
        const self = this;
        let $button = self.$form.find('.deskbook-button');
        self.button.active = self.current !== 0;
        if (self.button.active) {
            $button.removeClass('hidden');
        } else {
            $button.addClass('hidden');
        }
        console.log(self.button.active);
    },
    htmlCanSet(number) {
        const self = this;
        if (self.current === self.max) {
            return 'Вы выбрали <span class="checks-number">' + self.max + '</span> доступных вам справочников.';
        }
        if (self.current !== 0) {
            return 'Вы можете выбрать еще <span class="checks-number">' + self.current + '</span> ' + window.HELPER.units(self.current, ['справочник', 'справочника', 'справочников']);
        } else {
            return 'Вы можете выбрать <span class="checks-number">' + self.max + '</span> любых справочников и получить доступ к ним в личном кабинете.';
        }
    }
};
