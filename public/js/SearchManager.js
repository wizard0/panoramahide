(function (window, $) {
    if (!!window.JSSearchManager) return;
    
    window.JSSearchManager = function () {
        // $('#saveSearch').on('click', $.proxy(this.saveSearch, this));
    }

    window.JSSearchManager.prototype.saveSearch = function(event) {
        // console.log($(event.target).data('target'));
        // if ($(event.target).data('target') == '#searchesModal')
        //     $.ajax({
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //         },
        //         url: '/save-search',
        //         method: 'POST',
        //         data: $('#searchBar').serialize(),
        //         success: function (res) {
        //             alert('Поиск успешно сохранен');
        //         }
        //     });
    }

})(window, jQuery)
