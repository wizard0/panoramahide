(function (window, $) {
    if (!!window.JSAdminMenuManager) return;

    window.JSAdminMenuManager = function () {
        this.container = $('div#ajax-container');

        $('#admin-menu-sidebar a').on('click', $.proxy(this.loadPage, this));
    }

    window.JSAdminMenuManager.prototype.loadPage = function(event) {
        console.log();
        var _container = this.container;
        var href = $(event.target).attr('href');

        if (href !== '#')
        $.ajax({
            method: 'GET',
            url: href,
            success: function (res) {
                _container.html('');
                _container.html($(res).find('#ajax-container'));
            }
        });
        return false;
    }

})(window, jQuery)
