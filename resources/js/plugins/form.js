$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': window.Laravel}
});

let ajaxForm = {

    options: {
        ajaxLink: true,
        ajaxForm: true,
        ajaxTabs: true,
        validation: {
            helpClass: 'help',
            errorClass: 'is-danger',
            helpErrorClass: '.help.is-danger'
        },
        innerFormSubmit: '.inner-form-submit',
        loadingClass: 'is-loading'
    },

    data: {},

    loading: {
        container: [
            'dialog__loading', 'is-black', 'is-container'
        ]
    },

    form: null,
    tagName: null,

    bind(sElem, sDelegateFrom, sAction) {
        const self = this;
        sDelegateFrom = sDelegateFrom || '';
        sAction = sAction || 'submit';
        let fn = function (event) {
            event.preventDefault();
            self.form = $(event.currentTarget);
            self.tagName = self.form.get(0).tagName;
            self.send();
            return false;
        };
        fn = _.bind(fn, this);
        if (sDelegateFrom) {
            $(sDelegateFrom).on(sAction, sElem, fn);
        } else {
            $(sElem).on(sAction, fn);
        }
    },

    send() {
        const self = this;
        if (self.form.attr('method') === 'get') {

        } else {
            self.post();
        }
    },

    post() {
        const self = this;
        let data;
        self.before();
        data = self.getFormData();
        self.clearValidate();
        if (!self.validate()) {
            self.notification({
                type: 'error',
                text: 'Заполните обязательные поля',
                title: 'Ошибка',
            });
            return;
        }
        self.startLoading();
        if (!self.before(data)) {
            return;
        }
        $.ajax({
            url: self.form.attr('action'),
            type: "POST",
            data: data,
            success: function (result) {
                self.stopLoading();

                if (result.toastr) {
                    self.notification(result.toastr);
                }
                self.after(result);

                if (result.success) {
                    //self.after(result);
                } else if (result.error) {
                    self.showError(result.message);
                }
                if (result.item) {
                    self.setItemError(result.item);
                }
                if (self.form.data('append') && result.view) {
                    $(self.form.data('append-container')).html(result.view);
                }
                if (self.form.data('pagination') && result.view) {
                    self.pagination(result);
                }
                if (self.form.data('search') && result.view) {
                    $(self.form.data('pagination-container')).html(result.view);
                }
                if (self.form.data('tab') && result.view) {
                    $('.ajax-tabs').find('li').removeClass('is-active');
                    self.form.closest('li').addClass('is-active');
                    $(self.form.data('container')).html(result.view);
                }
                if (result.push) {
                    self.push(result.push);
                }
            },
            error: function (data, status, headers, config) {
                if (data.toastr) {
                    self.notification(data.toastr);
                }
                self.stopLoading();

                self.validateServer(data);
            }
        });
    },

    notification(notification) {
        window.toastr.options.closeButton = false;
        window.toastr.options.closeDuration = 10;
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

    get() {

    },

    submit() {

    },

    stopLoading() {
        const self = this;
        self.form.find(self.options.innerFormSubmit).removeClass(self.options.loadingClass);
        self.form.removeClass(self.options.loadingClass);
        self.form.closest('.select').removeClass(self.options.loadingClass);

        if (self.form.data('loading-container')) {
            for (let key in self.loading.container) {
                $(self.form.data('loading-container')).removeClass(self.loading.container[key])
            }
        }
    },

    startLoading() {
        const self = this;
        self.form.find(this.options.innerFormSubmit).addClass(self.options.loadingClass);

        self.form.closest('.select').addClass(self.options.loadingClass);

        if (self.form.data('pagination')) {
            self.form.addClass(self.options.loadingClass);
        }
        if (self.form.data('loading')) {
            self.form.addClass(self.options.loadingClass);
        }
    },

    after(result) {
        const self = this;
        let sCallbacks = self.form.data('callback') || result.callback;
        let bDefaultsCall = true;
        if (sCallbacks) {
            let aCallbacks = _.split(sCallbacks, ',');
            if (_.first(aCallbacks) === '@') {
                bDefaultsCall = false;
                aCallbacks = _.drop(aCallbacks);
            }
            _.each(aCallbacks, function (val) {
                let sFuncName = _.trim(val);
                if (_.isFunction(window['after-' + sFuncName])) {
                    window['after-' + sFuncName](result, self.form);
                }
            });
        }
        self.ajaxInitPlugins();

        if (bDefaultsCall) {
            self.afterDefault(result);
        }
        if (result.redirect) {
            window.location.replace(result.redirect);
        }
        if (result.post) {
            if (result.post.form) {
                $('body').append(result.post.form);
                let form = $('#ext_auth_form');
                form.submit();
                form.remove();
            }
        }
        if (result._blank) {
            let linkToDownload = result._blank;
            let downloadLink = document.createElement('a');
            downloadLink.id = "link-to-download";
            downloadLink.href = linkToDownload;
            downloadLink.setAttribute("target", "_blank");
            document.body.appendChild(downloadLink);
            downloadLink.click();
            setTimeout(function () {
                $('#link-to-download').remove();
            }, 1000);
        }
        if (this.form.data('has-active')) {
            let aItems = _.split(this.form.data('items'), ',');
            _.each(aItems, function (val) {
                let sItem = _.trim(val);
                $(sItem).removeClass('is-active');
                if (!self.form.hasClass('is-active')) {
                    self.form.addClass('is-active');
                    if (self.form.get(0).tagName === 'SELECT') {
                        self.form.find('option').removeAttr('selected')
                            .filter('[value=' + self.form.val() + ']')
                            .attr('selected', true)
                    }
                }
            });
            if (self.form.get(0).tagName !== 'SELECT') {
                console.log('!== SELECT');
                _.each(aItems, function (val) {
                    let $sItem = $(_.trim(val));
                    if ($sItem.length) {
                        if ($sItem.get(0).tagName === 'SELECT') {
                            console.log('=== SELECT');
                            /*
                            $(sItem).find('option').removeAttr('selected')
                                .filter('[value=0]')
                                .attr('selected', true);
                            */
                            $sItem.find('option').prop("selected", false);
                        }
                    }
                });
            }
        }
    },

    afterDefault(result) {
        const self = this;
        self.form.find('input, div').removeClass('__error');
        $('.text-error[data-name="error"]').empty();
    },

    before() {
        const self = this;
        if (self.form.data('loading-container')) {
            for (let key in self.loading.container) {
                $(self.form.data('loading-container')).addClass(self.loading.container[key])
            }
        }

        let sCallbacks = self.form.data('before');
        let goToAjax = true;
        if (sCallbacks !== undefined) {
            let self = this;
            if (sCallbacks) {
                let aCallbacks = _.split(sCallbacks, ',');
                _.each(aCallbacks, function (val) {
                    let sFuncName = _.trim(val);
                    if (_.isFunction(window['before-' + sFuncName])) {
                        goToAjax = window['before-' + sFuncName](self.form);
                    }
                });
            }
        }
        let messageLoading = self.form.find('.message-loading');
        if (messageLoading) {
            messageLoading.empty();
            messageLoading.addClass('is-loading');
            messageLoading.removeClass('__is-danger');
        }
        return goToAjax;
    },

    beforeDefault() {

    },

    clearValidate: function () {
        const self = this;
        self.form.find('.help.' + self.options.validation.errorClass).remove();
        self.form.find('input.' + self.options.validation.errorClass).removeClass(self.options.validation.errorClass);
    },
    validate: function () {
        const self = this;
        let $required = self.form.find('input[required]');
        //let $required = this.form.find('[data-required="1"]');
        if (self.form.data('required-by-radio')) {
            let labelRadio = self.form.find('.label-radio.active');

            $.each($required, function (key) {
                let $closestContainer = $(this).closest(self.form.data('required-by-radio-blocks'));
                if ($closestContainer.length) {
                    if ($closestContainer.data('id') !== labelRadio.data('id')) {
                        delete $required[key];
                    }
                }
            });
            $required = $required.filter(function (n) {
                return n !== undefined;
            });
            console.log($required);
        }
        let bResult = true;
        $required.each(function (i, e) {
            let $elem = $(e);
            let sElemType = $elem.get(0).tagName;
            let bFilled = ($elem.is(':checkbox')) ? $elem.prop('checked') : $elem.val();
            if (!bFilled) {
                $elem.addClass(self.options.validation.errorClass);
                bResult = false;
                switch (sElemType) {
                    case 'SELECT':
                        if ($elem.hasClass('combobox') || $elem.parent().hasClass('__combobox')) {
                            $elem.closest('.form-group').addClass('__error');
                        }
                        if ($elem.data('role') === 'chosen-select') {
                            $elem.closest('.form-group').addClass('__error');
                        }
                        break;
                    case 'INPUT':
                        if ($elem.is(':checkbox')) {
                            $elem.parent().addClass('__error');
                        } else {
                            $elem.addClass('__error');
                        }
                        break;
                    default:
                        $elem.addClass('__error');
                        break;
                }
            }
        });
        return bResult;
    },

    validateServer: function (result) {
        const self = this;

        let resultJson = result.responseJSON;
        if (resultJson.errors) {
            resultJson = resultJson.errors;
        }
        for (let key in resultJson) {
            let $input = self.form.find('input[name="' + key + '"]');
            $input.addClass(self.options.validation.errorClass);
            /*
            setTimeout(function() {
                input.removeClass(self.options.validation.errorClass);
            }, 10000);
            */
            let message;
            if (_.isArray(resultJson[key])) {
                message = resultJson[key][0];
            } else {
                message = resultJson[key];
            }
            $input.closest('.form-group').append(self.validationTemplate(message, false));
            //this.form.find('.text-error[data-name="' + key + '"]').text(result.responseJSON[key][0]);
            if (key === 'error') {
                self.showError(message);
            }
            $input.closest('.form-holder').append(self.validationTemplate(message, false));
            //this.form.find('.text-error[data-name="' + key + '"]').text(result.responseJSON[key][0]);
            if (key === 'error') {
                self.showError(message);
            }
            if (key === 'g-recaptcha-response') {
                self.form.find('textarea[name="' + key + '"]').closest('.form-group').append(self.validationTemplate(message, false));
            }
        }
    },

    getFormData: function () {
        const self = this;
        let data = {};
        let name;
        if (self.tagName === 'FORM') {
            data = self.form.serializeArray();
        } else if (self.tagName === 'SELECT') {
            name = self.form.attr('name');
            data['' + name] = self.form.val();
        } else if (self.tagName === 'INPUT' && self.form.attr('type') === 'checkbox') {
            data = self.form.data();
            name = self.form.attr('name');
            if (self.form.is(':checked')) {
                data['' + name] = 1;
            } else {
                data['' + name] = 0;
            }
        } else if (self.tagName === 'A' && self.form.attr('value')) {
            name = self.form.attr('name');
            data['' + name] = self.form.attr('value');
        } else {
            data = self.form.data();
        }
        if (!data._token || data._token === undefined) {
            data._token = window.Laravel;
        }
        if (data['bs.tooltip'] !== undefined) {
            delete data['bs.tooltip'];
        }
        if (self.form.data('form-data')) {
            let supportData = [];
            _.each(data, function (value, key) {
                if (value.name === undefined) {
                    let val = value;
                    value.name = key;
                    value.value = val;
                }
                supportData = self.getFormDataPushKeyValue(supportData, value.name, value.value);
            });
            let sData = self.form.data('form-data');
            if (sData) {
                sData = _.split(sData, ',');
                _.each(sData, function (val) {
                    let $element = $(_.trim(val));
                    if ($element.get(0).tagName === 'INPUT') {
                        if ($element.is(':checkbox')) {
                            supportData = self.getFormDataPushKeyValue(supportData, $element.attr('name'), $element.is(':checked') ? 1 : 0);
                        } else {
                            supportData = self.getFormDataPushKeyValue(supportData, $element.attr('name'), $element.val());
                        }
                    }
                    if ($element.get(0).tagName === 'SELECT') {
                        supportData = self.getFormDataPushKeyValue(supportData, $element.attr('name'), $element.val());
                    }
                    if ($element.get(0).tagName === 'FORM') {
                        _.each($element.serializeArray(), function (val) {
                            supportData = self.getFormDataPushKeyValue(supportData, val.name, val.value);
                        });
                    }
                });
            }
            data = supportData;
        }
        console.log(data);
        return data;
    },

    getFormDataPushKeyValue(data, key, value) {
        data.push({
            name: key,
            value: value,
        });
        return data;
    },

    showError: function (sMessage) {
        this.form.prepend(this.validationTemplate(sMessage, true));
    },

    setItemError: function (item) {
        console.log(item);
        console.log('[data-item-id="' + item + '"]');
        this.form.find('[data-item-id="' + item + '"]').addClass('__error');
    },

    validationTemplate: function (text, center) {
        let classes = this.options.validation.helpClass + ' ' + this.options.validation.errorClass;
        if (center) {
            classes = classes + '  has-text-centered';
        }
        return '<span class="' + classes + '" style="margin-bottom: 10px;">' + text + '</span>';
    },

    ajaxInitPlugins: function () {
        let sInit = this.form.data('ajax-init');
        if (sInit) {
            let aInit = _.split(sInit, ',');
            _.each(aInit, function (val) {
                let sFuncName = _.trim(val);
                if (_.isFunction(window[sFuncName])) {
                    window[sFuncName]();
                }
            });
        }
    }
};


$(document).ready(function () {
    ajaxForm.bind('.ajax-form', 'body');
    ajaxForm.bind('.ajax-link', 'body', 'click');
    ajaxForm.bind('.ajax-select', 'body', 'change');
    ajaxForm.bind('.ajax-search', 'body', 'keyup');
    ajaxForm.bind('.ajax-checkbox', 'body', 'change');

    $('body').on('click', 'button.inner-form-submit[type="submit"]', function (event) {
        event.preventDefault();
        $(this).closest('form.ajax-form').submit();
    });
});
