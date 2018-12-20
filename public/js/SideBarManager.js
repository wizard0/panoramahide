/**
 * Created by wizard on 12/19/18.
 */
(function (window, $) {
    if (!!window.JSSideBarManager) return;

    window.JSSideBarManager = function (params) {
        this.subscribeBtn = $('.get-access._access');
        this.journals = $('input[name="article-choise"]');
        // this.quoteBtn = $('.actions-menu .action-item._quote');
        // this.copyQuoteBtn = $()

        $('input[name="article-choise"]').on('change', $.proxy(this.processJournalChoice, this));
        this.subscribeBtn.on('click', $.proxy(this.subscribe, this));
        $('#recommend form').on('submit', $.proxy(this.recommendSubmit, this));
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
        this.countJournals();
        this.processQuote();
    }

    window.JSSideBarManager.prototype.processQuote = function () {
        var text = "";
        $.each(this.journals.filter(':checked'), function (index, item) {
            var element = $('.magazine-item._magazine[data-id="' + $(item).val() + '"]');
            text += '<a href="' + $(element).data('link') + '">' + $(element).find('.journalName').text() + "</a><br>";
        });
        $('#quote ._text').html(text);
    }

    window.JSSideBarManager.prototype.countJournals = function () {
        var recommendArrayIds = $('#recommend input[name="ids"]');
        recommendArrayIds.val('');
        $.each(this.journals.filter(':checked'), function (index, element) {
            recommendArrayIds.val(recommendArrayIds.val() + "," + $(element).val());
        });

    }

    window.JSSideBarManager.prototype.disableBtn = function () {
        if (this.journals.filter(':checked').length > 1) {
            this.subscribeBtn.addClass('disabled').removeClass('accent');
        } else {
            this.subscribeBtn.addClass('accent').removeClass('disabled');
        }
    }

    window.JSSideBarManager.prototype.subscribe = function () {
        var journal = this.journals.filter(':checked').val();
        window.location = $('._magazine.magazine-item[data-id="' + journal + '"]').data('link-subscribe');
    }
})(window, jQuery)
