$(document).ready(function() {
    deskbooksForm.initEvents();

    if ($('#reader').length) {
        let $currentFooterLink = $('#cur_heading a');
        $('#reader-panel').on('scroll', function () {
            $('#reader-panel article').each(function () {
                let ThisOffset = $(this).offset();
                if (ThisOffset.top < 220) {
                    let id = $(this).find('h2').attr('id');
                    $currentFooterLink.text($(this).closest('section').find('.heading').text());
                    $currentFooterLink.attr('href', '#' + id);
                }
            });
        });
        $currentFooterLink.text($('#article00').closest('section').find('.heading').text());
        $currentFooterLink.attr('href', '#article00');
        $('a[href*="#"]').smoothScroll({
            offset: -100,
            scrollElement: $('#reader-panel'),
            beforeScroll: function() {
                //window.slideout.close();
            }
        });
    }
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
