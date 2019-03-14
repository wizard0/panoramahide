$(document).ready(function() {
    deskbooksForm.initEvents();


    if(typeof $.fn.datetimepicker !== 'undefined') {
        $('.datetimepicker[data-format="date"]').datetimepicker({
            format: 'DD-MM-YYYY',
            locale: 'ru',
        });
        $('.datetimepicker[data-format="datetime"]').datetimepicker({
            format: 'LT',
            locale: 'ru',
        });
    }

    // личный кабинет, смена вкладок для редактирования профиля
    $('input[name=chgForm]').change(function() {
        $('#profileForm').toggle();
        $('#passwordForm').toggle();
    });

    // личный кабинет, смена вкладок оформление заказа
    $('input[name=person_type]').change(function() {
        $('#phys_user_form').toggleClass('hidden');
        $('#legal_user_form').toggleClass('hidden');
    });

    // валидация оформления заказов, закомментирован из-за ajax-form
    $('#order_confirm_button').click(function() {
        let $content = $('#order_form_content');
        let $legal = $content.find('#legal_user_form');
        let $phys = $content.find('#phys_user_form');
        if (!$legal.hasClass('hidden')) {
            $legal.find('form').submit();
        }
        if (!$phys.hasClass('hidden')) {
            $phys.find('form').submit();
        }
    });
    /*
    $('#order_confirm_button').click(function() {
        console.log('order_confirm_button');
        $('.is-danger').removeClass('is-danger');
        let result = true;
        let form = 'l_order_form';
        let fields = ['org_name', 'l_surname', 'l_name', 'l_patronymic', 'l_phone', 'l_email', 'l_personal_data_consent', 'l_contract_accept'];
        if ($('input[name=person_type]:checked').val() == 'physical') {
            form = 'p_order_form';
            fields = ['surname','name','patronymic','phone','email','personal_data_consent','contract_accept'];
        }

        $('#' + form).find(':input').each(function() {
            console.log($(this));
            if (this.hasAttribute('required')) {
                if ($(this).attr('type') == 'checkbox' && !$(this).is(':checked')) {
                    $(this).addClass('is-danger');
                    result = false;
                } else if ((($(this).attr('name') == 'phone' || $(this).attr('name') == 'l_phone') && $(this).val().length != 18) ||
                    (($(this).attr('name') == 'email' || $(this).attr('name') == 'l_email') && !validateEmail($(this).val())) || $(this).val() == '') {
                    $(this).addClass('is-danger');
                    result = false;
                }
            }
        });

        if (result) {
            $('#' + form).submit();
        }
    });
    */
});

function validateEmail(email) {
    let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

/**
 * Для выбора журналов
 */
const deskbooksForm = {

    /**
     * Текущее количесво выбранных журналов
     */
    current: 0,

    /**
     * Максимальное количество
     */
    max: 5,

    /**
     * Сама форма
     */
    $form: null,

    /**
     * Чекбоксы
     */
    $checkboxes: null,

    /**
     *
     */
    $sections: null,

    /**
     * Кнопка submit
     */
    button: {

        /**
         * Её видимость
         */
        active: false,
    },

    /**
     * События
     */
    initEvents() {
        const self = this;
        self.$form = $('.--journal-checkboxes');
        self.$sections = self.$form.find('.--journal-section-checkboxes');

        self.max = 0;
        self.$sections.each(function () {
            let $section = $(this);
            let current = self.getCheckedBySection($section).length;
            let max = self.getMaxBySection($section);
            self.setCurrentBySection($section, current);
            self.setDisabledBySection($section, current === max);
            self.max += $section.data('max');
        });
        self.getCheckboxes().each(function () {
            $(this).on('change', function () {
                self.checkCheckboxesEvent($(this), true);
            });
            if ($(this).is(':checked')) {
                self.checkCheckboxesEvent($(this), false);
            }
        });
    },

    /**
     * Событие чекбоксов
     *
     * @param $item
     * @param checkCan
     */
    checkCheckboxesEvent($item, checkCan) {
        const self = this;
        if ($item.is(':checked') && checkCan) {
            if (!self.canSet()) {
                $item.prop('checked', false);
            }
        }
        let $section = $item.closest('.--journal-section-checkboxes');

        let current = self.getCheckedBySection($section).length;
        let max = self.getMaxBySection($section);
        self.setCurrentBySection($section, current);
        self.setDisabledBySection($section, current === max);
    },
    /**
     *
     * @param $section
     * @returns {number}
     */
    getMaxBySection($section) {
        return parseInt($section.find('.info-count .max').text());
    },

    /**
     *
     * @param $section
     * @returns {number}
     */
    getCurrentBySection($section) {
        return parseInt($section.find('.info-count .selected').text());
    },

    /**
     *
     * @param $section
     * @returns {*}
     */
    getCheckedBySection($section) {
        return $section.find('.journal-checkbox input:checked');
    },

    /**
     *
     * @param $section
     * @param value
     * @returns {*}
     */
    setMaxBySection($section, value) {
        return $section.find('.info-count .max').text(value);
    },

    /**
     *
     * @param $section
     * @param value
     * @returns {*}
     */
    setCurrentBySection($section, value) {
        return $section.find('.info-count .selected').text(value);
    },

    /**
     *
     * @param $section
     * @param disabled
     */
    setDisabledBySection($section, disabled) {
        const self = this;
        let $checkboxes = $section.find('.journal-checkbox input').not(':checked');
        if (disabled) {
            $checkboxes.prop('disabled', true);
        } else {
            $checkboxes.prop('disabled', false);
        }
        if (self.max !== undefined) {
            self.$form.parent().find('.inform').html(self.htmlCanSet());
        }
    },

    /**
     *
     * @returns {boolean}
     */
    canSet() {
        const self = this;
        return self.current < self.max;
    },

    /**
     *
     *
     * @param disabled
     */
    setDisabled(disabled) {
        const self = this;
        let $checkboxes = self.getCheckboxesNotChecked();
        if (disabled) {
            $checkboxes.prop('disabled', true);
        } else {
            $checkboxes.prop('disabled', false);
        }
        if (self.max !== undefined) {
            self.$form.parent().find('.inform').html(self.htmlCanSet());
        }
    },

    /**
     * Присвоить выбранное количество журналов
     */
    setCurrent() {
        const self = this;
        self.current = self.getChecked();
        self.setButtonActive();
    },

    /**
     * Количество выбранных журналов
     *
     * @returns {*}
     */
    getChecked() {
        const self = this;
        return self.getCheckboxesChecked().length;
    },

    /**
     * Показать кнопку с отправкой формы
     */
    setButtonActive() {
        const self = this;
        let $button = self.$form.find('.deskbook-button');
        self.button.active = self.current !== 0;
        if (self.button.active) {
            $button.removeClass('hidden');
            self.setTitleStyles(true);
        } else {
            self.setTitleStyles(false);
            $button.addClass('hidden');
        }
    },

    /**
     * Текст для заголовка
     *
     * @returns {string}
     */
    htmlCanSet() {
        const self = this;
        self.current = self.getCheckboxesChecked().length;
        self.setButtonActive();
        if (self.current === self.max) {
            return self.htmlMaxNumberWrapper('Вы выбрали', self.max, 'доступных вам справочников.');
        }
        if (self.current !== 0) {
            let odd = self.max - self.current;
            return self.htmlMaxNumberWrapper('Вы можете выбрать еще', self.max - self.current, window.HELPER.units(odd, ['справочник', 'справочника', 'справочников']) + '.');
        } else {
            return self.htmlMaxNumberWrapper('Вы можете выбрать', self.max, 'любых справочников и получить доступ к ним в личном кабинете.');
        }
    },

    /**
     * Обертка для количества выбранных журналов
     *
     * @param before
     * @param number
     * @param after
     * @returns {string}
     */
    htmlMaxNumberWrapper(before, number, after) {
        return before + ' <span class="checks-number">' + number + '</span> ' + after;
    },

    /**
     * Присвоить заголовку класс
     *
     * @param active
     */
    setTitleStyles(active) {
        let $title = $('.inform-cell.high-cell');
        let hasActiveClass = 'has-active';
        if (active) {
            if (!$title.hasClass(hasActiveClass)) {
                $title.addClass(hasActiveClass)
            }
        } else {
            if ($title.hasClass(hasActiveClass)) {
                $title.removeClass(hasActiveClass);
            }
        }
    },

    /**
     * Все инпуты
     *
     * @returns {*}
     */
    getCheckboxes() {
        const self = this;
        return self.$form.find('.journal-checkbox input');
        //return self.$form.find('.journal-checkbox input').not(':checked');
    },

    /**
     * Все выбранные инпуты
     *
     * @returns {*}
     */
    getCheckboxesChecked() {
        const self = this;
        return self.$form.find('.journal-checkbox input:checked');
    },

    /**
     * Все не выбранные инпуты
     *
     * @returns {*}
     */
    getCheckboxesNotChecked() {
        const self = this;
        return self.$form.find('.journal-checkbox input').not(':checked');
    },
};
