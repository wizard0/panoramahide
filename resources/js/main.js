$(document).ready(function() {
    deskbooksForm.initEvents();
});

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
        self.max = self.$form.data('max');
        let maxChecked = self.getChecked();
        if (maxChecked > self.max) {
            self.max = maxChecked;
        }
        self.setCurrent();
        self.setButtonActive();
        self.setDisabled(self.current === self.max);

        self.$form.find('.journal-checkbox input').each(function () {
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
        self.setCurrent();
        self.setDisabled(self.current === self.max);
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
        let $checkboxes = self.$form.find('.journal-checkbox input').not(':checked');
        if (disabled) {
            $checkboxes.prop('disabled', true);
        } else {
            $checkboxes.prop('disabled', false);
        }
        self.$form.parent().find('.inform').html(self.htmlCanSet());
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
        return self.$form.find('.journal-checkbox input:checked').length;
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
        if (self.current === self.max) {
            return 'Вы выбрали <span class="checks-number">' + self.max + '</span> доступных вам справочников.';
        }
        if (self.current !== 0) {
            let odd = self.max - self.current;
            return 'Вы можете выбрать еще <span class="checks-number">' + odd + '</span> ' + window.HELPER.units(odd, ['справочник', 'справочника', 'справочников']);
        } else {
            return 'Вы можете выбрать <span class="checks-number">' + self.max + '</span> любых справочников и получить доступ к ним в личном кабинете.';
        }
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
    }
};
