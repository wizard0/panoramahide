/**
 * Created by wizard on 12/19/18.
 */
(function (window, $) {
    if (!!window.JSSideBarManager) return;

    window.JSSideBarManager = function (params) {
        this.subscribeBtn = $('.get-access._access');
        this.items = $('input[name="article-choise"]');
        this.favoriteBtn = $('a._add_to_favorite');
        // this.quoteBtn = $('.actions-menu .action-item._quote');
        // this.copyQuoteBtn = $()

        $('input[name="article-choise"]').on('change', $.proxy(this.processJournalChoice, this));
        this.subscribeBtn.on('click', $.proxy(this.subscribeTo, this));
        $('#recommend form').on('submit', $.proxy(this.recommendSubmit, this));
        this.favoriteBtn.on('click', $.proxy(this.addToFavorites, this));
    }

    window.JSSideBarManager.prototype.recommendSubmit = function (event) {
        event.preventDefault();
        console.log(event.target);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: $(event.target).attr('action'),
            method: 'POST',
            data: $(event.target).serialize(),
            success: function (res) {
                console.log('recommend return succeess');
            }
        });
        return false;
    }

    window.JSSideBarManager.prototype.processJournalChoice = function () {
        this.disableBtn();
        this.countAndTypes();
        this.processQuote();
    }

    window.JSSideBarManager.prototype.processQuote = function () {
        var text = "";
        $.each(this.items.filter(':checked'), function (index, item) {
            var element = $('.magazine-item._magazine[data-id="' + $(item).val() + '"]');
            text += '<a href="' + $(element).data('link') + '">' + $(element).find('.journalName').text() + "</a><br>";
        });
        $('#quote ._text').html(text);
    }

    window.JSSideBarManager.prototype.countAndTypes = function () {
        var recommendArrayIds = $('#recommend input[name="ids"]');
        recommendArrayIds.val('');
        /**
         * jsonData has to be like "[]{id:id, type:type}"
         */
        var idByType = [];
        $.each(this.items.filter(':checked'), function (index, element) {
            idByType[index] = {id : $(element).val(), type:  $(element).data('type')};
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

    window.JSSideBarManager.prototype.subscribeTo = function () {
        var journal = this.items.filter(':checked').val();
        window.location = $('._magazine.magazine-item[data-id="' + journal + '"]').data('link-subscribe');
    }

    window.JSSideBarManager.prototype.addToFavorites = function (event) {
        event.preventDefault();
        // taking ids from recommendation modal form, cause tis not so bad
        // this would be a string like ',1,2,3'
        var data = $('#recommend input[name="ids"]').val();

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: this.favoriteBtn.attr('href'),
            method: 'POST',
            data: {data: data},
            success: function (res) {
                console.log('warewarewa return succeess');
            }
        });
    }
})(window, jQuery)
