/**
 * Created by wizard on 2/18/19.
 */

(function(window, $) {
    window.ajaxLoadPage = function(destination, fromUrl, params) {
        var _destination = destination;
        _destination.html('');
        $.ajax({
            method: 'GET',
            url: fromUrl,
            data: params,
            success: function (res) {
                _destination.html(res);
            }
        });
    }
})(window, jQuery)
