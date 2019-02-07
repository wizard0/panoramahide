/**
 * Created by wizard on 12/19/18.
 */
(function (window, $) {
    if (!!window.JSSideBarManager) return;

    window.JSSideBarManager = function (params) {
        console.log('sidebar started');
        if (typeof params !== 'undefined') {
            params = JSON.parse(params);
            this.elementID = params.id;
            this.elementType = params.type;
            this.elementUrl = params.url;

            this.dataset = [{
                id: this.elementID,
                type: this.elementType
            }];

            $('#recommend input[name="ids"]').val(JSON.stringify(this.dataset));
        }
        this.subscribeBtn = $('.get-access._access');
        this.items = $('input[name="article-choise"]');
        this.favoriteBtn = $('a.action-item._add_to_favorite');

        $('input[name="article-choise"]').on('change', $.proxy(this.processChoice, this));

        this.subscribeBtn.on('click', $.proxy(this.subscribeTo, this));

        $('#recommend form').on('submit', $.proxy(this.recommendSubmit, this));
        this.favoriteBtn.on('click', $.proxy(this.addToFavorites, this));
    }

    window.JSSideBarManager.prototype.recommendSubmit = function (event) {
        event.preventDefault();

        var data = $(event.target).serialize();

        if (data.length > 0) {
            $.proxy(this.sendRequest(
                $(event.target).attr('action'),
                data,
                function (res) {
                    $('#recommend .close').click();
                    alert('Вы порекомендовали');
                }
            ), this);
        }

        return false;
    }

    window.JSSideBarManager.prototype.processChoice = function () {
        this.disableBtn();
        this.countAndTypes();
        this.processQuote();
    }

    window.JSSideBarManager.prototype.processQuote = function () {
        var text = "";
        $.each(this.items.filter(':checked'), function (index, item) {
            var element = $('.entity-item[data-id="' + $(item).val() + '"]');
            if ($(element).find('.itemName').length > 0) {
                text += $(element).find('.itemName').text() + "<br>";
            } else {
                var releaseName = $('.issue-line._number[data-id="' + $(item).val() + '"] .issue-num').text();
                var journalName = $('#journalName').text();
                text += journalName + '. ' + releaseName + "<br>";
            }
        });
        $('#quote ._text').html(text);
    }

    window.JSSideBarManager.prototype.countAndTypes = function () {
        var recommendArrayIds = $('#recommend input[name="ids"]');
        recommendArrayIds.val('');
        /**
         * jsonData has to be like "[{id:id, type:type}]"
         */
        var idByType = [];
        $.each(this.items.filter(':checked'), function (index, element) {
            idByType[index] = {id: $(element).val(), type: $(element).data('type')};
        });
        recommendArrayIds.val(JSON.stringify(idByType));
    }

    window.JSSideBarManager.prototype.disableBtn = function () {
        if (this.items.filter(':checked').length > 1) {
            this.subscribeBtn.addClass('disabled').removeClass('accent');
        } else {
            this.subscribeBtn.addClass('accent').removeClass('disabled');
        }
    }

    window.JSSideBarManager.prototype.subscribeTo = function (event) {
        event.preventDefault();
        if (this.items.filter(':checked').data('type') == 'article') {
            var id = this.items.filter(':checked').val();
            CartManager.addToCart('electronic', 'article', id);
            return;
        }
        if (typeof this.elementUrl != 'undefined') {
            window.location = this.elementUrl + '#subscribe';
            window.location.reload();
            return;
        }
        var journal = this.items.filter(':checked').val();
        window.location = $('._magazine.magazine-item[data-id="' + journal + '"]').data('link-subscribe');
    }

    window.JSSideBarManager.prototype.addToFavorites = function (event, data) {
        event.preventDefault();
        // taking ids from recommendation modal form, cause this
        // this would be a string like '[{id:id, type:type}]'
        if (typeof data == 'undefined') {
            var data = $('#recommend input[name="ids"]').val();
        }

        if (data.length > 0) {
            $.proxy(this.sendRequest(
                '/add-to-favorite',
                {data: data},
                function (res) {
                    alert('Добавлено в избранное');
                },
                function (xhr, textStatus) {
                    if (xhr.status == 401) {
                        $('#login-modal').modal('show')
                    }
                }
            ), this);
        }
    }

    window.JSSideBarManager.prototype.sendRequest = function (url, data, successCallback, completeCallback) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: url,
            method: 'POST',
            data: data,
            success: successCallback,
            complete: completeCallback
        });
    }
})(window, jQuery)
