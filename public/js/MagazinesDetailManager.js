/**
 * Created by wizard on 1/11/19.
 */

(function (window, $) {
    if (!!window.JSMagazineDetailManager) return;

    window.JSMagazineDetailManager = function (params) {
        if (typeof params !== 'undefined') {
            this.journalCode = params.code;
        }
        this.result = $('div.show-results');

        $('#toggleMenu01 a').on('click', $.proxy(this.processTab, this));
        if (window.location.hash !== "") {
            $.proxy(this.onloadTab(), this);
        }
    }

    window.JSMagazineDetailManager.prototype.onloadTab = function () {
        var tabName = window.location.hash.substring(1);

        // Applying active style for current tab
        $('#toggleMenu01 li.inner-menu-active').removeClass('inner-menu-active');
        $('#toggleMenu01 a[data-type="'+ tabName +'"]').parents('li').addClass('inner-menu-active');

        $.proxy(this.loadTab(tabName), this);
    }

    window.JSMagazineDetailManager.prototype.processTab = function (event) {
        var tab = event.target;
        var tabName = $(tab).data('type');

        // Applying active style for current tab
        $('#toggleMenu01 li.inner-menu-active').removeClass('inner-menu-active');
        $(tab).parents('li').addClass('inner-menu-active');

        // Removing get params if user switched tab
        // window.location.href = window.location.href.replace(window.location.search,'');
        // could be better...

        // Load new result
        $.proxy(this.loadTab(tabName), this);
    }

    window.JSMagazineDetailManager.prototype.loadTab = function (tabName) {
        var _result = this.result;

        // Empty result div
        _result.html('');

        // If we need pagination
        if (window.location.href.search(/.*page=(\d)+/) >= 0) {
            var data = {
                'code': this.journalCode,
                'tab': tabName,
                'page': window.location.href.match(/.*page=(\d)+/)[1],
            };
        } else { // If don't
            var data = {
                'code': this.journalCode,
                'tab': tabName,
            }
        }

        $.ajax({
            method: 'GET',
            url: '/magazines/ajax-get-page',
            data: data,
            success: function (res) {
                _result.html(res);
            }
        });
    }

})(window, jQuery)
