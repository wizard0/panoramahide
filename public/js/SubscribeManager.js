/**
 * Created by wizard on 1/23/19.
 */
(function (window, $) {
    if (!!window.JSSubscribeManager) return;

    window.JSSubscribeManager = function (params) {
        this.startMonth = $('#start_months');
        this.terms = $('#count_months');
        this.resultPrice = $('#cur_price');
        this.quantityInput = $('input#quantity');
        this.singlePrice = $('input#single_price');
        this.version = $('.container').find('input[name="version"]');

        if (typeof params != 'undefined') {
            params = JSON.parse(params);
            this.prices = params.prices;
            this.monthNames = params.monthNames;
            this.monthTerms = params.monthTerms;

            // Presets start data of the subscriptions
            this.version.on('change', $.proxy(this.changeVersion, this));
            // Quantity changing
            $('div.quantity button').on('click', $.proxy(this.quantityButtonClicked, this));
            this.quantityInput.on('change', $.proxy(this.changeQuantity, this));
            // Events on choosing selectors
            this.startMonth.on('change', $.proxy(this.startMonthChanged, this));
            this.terms.on('change', $.proxy(this.termChanged, this));
        }
    }

    window.JSSubscribeManager.prototype.changeVersion = function (e) {
        var version = $(e.target).val();
        $.proxy(this.presetStart(version), this);
        $.proxy(this.presetTerms(version), this);
        $.proxy(this.presetPrice(version), this);
    }

    window.JSSubscribeManager.prototype.presetStart = function (version) {
        var _monthNames = this.monthNames;
        var _startMonth = this.startMonth;
        _startMonth.html('');
        $.each(this.prices[version], function (terms, value) {
            $.each(value, function (year, startMonths) {
                $.each(startMonths, function (month, price) {
                    var monthFormatted = ('0' + month).slice(-2);
                    var option = $('<option></option>')
                        .val(year + monthFormatted)
                        .html(_monthNames[month] + ' ' + year);
                    _startMonth.append(option);
                });
            });

            return false;
        });

    }

    window.JSSubscribeManager.prototype.presetTerms = function (version) {
        var _terms = this.terms;
        var _monthTerms = this.monthTerms;
        _terms.html('');
        $.each(this.prices[version], function (term, value) {
            var option = $('<option></option>').val(term).html(_monthTerms[term]);
            _terms.append(option);
        });
    }

    window.JSSubscribeManager.prototype.presetPrice = function (version) {
        var _resultPrice = this.resultPrice;
        var _singlePrice = this.singlePrice;

        $.each(this.prices[version], function (terms, value) {
            $.each(value, function (year, startMonths) {
                $.each(startMonths, function (month, price) {
                    _resultPrice.html(price);
                    _singlePrice.val(price);

                    return false;
                });

                return false;
            });

            return false;
        });
    }

    window.JSSubscribeManager.prototype.quantityButtonClicked = function (e) {
        switch ($(e.target).data('input-stepper')) {
            case 'increase':
                this.quantityInput.val(this.quantityInput.val() * 1 + 1);
                break;
            case 'decrease':
                if (this.quantityInput.val() > 1) {
                    this.quantityInput.val(this.quantityInput.val() * 1 - 1);
                }
                break;
        }
        this.quantityInput.trigger('change');
    }

    window.JSSubscribeManager.prototype.changeQuantity = function (e) {
        this.resultPrice.html(this.singlePrice.val() * this.quantityInput.val());
    }

    window.JSSubscribeManager.prototype.startMonthChanged = function (e) {
        var startMonth = $(e.target).val();
        var year = startMonth.match(/^(\d{4})(\d{2})$/)[1];
        var version = this.version.filter(':checked').val();

        var _terms = this.terms;
        var _monthTerms = this.monthTerms;
        var currentTerm = this.terms.val();
        _terms.html('');
        $.each(this.prices[version], function (term, value) {
            if (value[year][startMonth] != 'undefined') {
                var option = $('<option></option>').val(term).html(_monthTerms[term]);
                _terms.append(option);
            }
        });
        if (_terms.has('[value="' + currentTerm + '"]').length > 0) {
            this.terms.val(currentTerm);
        }

        $.proxy(this.setPrice(), this);
    }

    window.JSSubscribeManager.prototype.termChanged = function (e) {
        var term = $(e.target).val();
        var version = this.version.filter(':checked').val();

        var _monthNames = this.monthNames;
        var _startMonth = this.startMonth;
        var currentStartMonth = this.startMonth.val();
        _startMonth.html('');
        $.each(this.prices[version][term], function (year, startMonths) {
            $.each(startMonths, function (month, price) {
                var monthFormatted = ('0' + month).slice(-2);
                var option = $('<option></option>')
                    .val(year + monthFormatted)
                    .html(_monthNames[month] + ' ' + year);
                _startMonth.append(option);
            });
        });
        if (_startMonth.has('[value="' + currentStartMonth + '"]').length > 0) {
            this.startMonth.val(currentStartMonth);
        }

        $.proxy(this.setPrice(), this);
    }

    window.JSSubscribeManager.prototype.setPrice = function () {
        var term = this.terms.val();
        var version = this.version.filter(':checked').val();
        var startMonth = this.startMonth.val();
        var year = startMonth.match(/^(\d{4})(\d{2})$/)[1];
        var month = parseInt(startMonth.match(/^(\d{4})(\d{2})$/)[2]);
        var quantity = this.quantityInput.val();

        var price = this.prices[version][term][year][month];
        this.singlePrice.val(price);
        this.resultPrice.html(price * quantity);
    }
})(window, jQuery)
