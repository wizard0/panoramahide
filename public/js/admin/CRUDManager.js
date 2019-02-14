/**
 * Created by wizard on 2/8/19.
 */
(function(window, $) {
    if (!!window.JSCRUDManager) return;

    window.JSCRUDManager = function () {
        $('.delete-action').on('click', $.proxy(this.delete, this));
        $('#translate_locale').on('change', $.proxy(this.setLocale, this));
    }

    window.JSCRUDManager.prototype.delete = function (e) {
        var id = $(e.target).data('id');
        var url = window.location + '/' + id;
        var _t = this;
        $.ajax({
            method: 'DELETE',
            url: url,
            data: {
                id: id
            },
            success: function () {
                $.proxy(_t.hideDeleted(id), _t);
            }
        });
    }

    window.JSCRUDManager.prototype.hideDeleted = function (id) {
        $('table tr[data-id="' + id + '"]]').hide();
    }

    window.JSCRUDManager.prototype.setLocale = function (e) {
        window.location = window.location.pathname + '?translate_locale=' + $(e.target).val();
    }
})(window, jQuery)
