/**
 * Created by wizard on 12/7/18.
 */

(function (window, $) {
    if (!!window.JSCustomBreadManager) return;

    window.JSCustomBreadManager = function (params) {
        params = JSON.parse(params);

        // this.fieldIDs2JSON = params.fieldIDs2JSON;
        // this.resultID2JSON = params.resultID2JSON;

        this.image_i18n = $('[name="image_i18n"]').val();
        this.preview_image_i18n = $('[name="preview_image_i18n"]').val();
        this.css4EditImages = {
            'max-width' : '200px',
            'height' : 'auto',
            'clear' : 'both',
            'display' : 'block',
            'padding' : '2px',
            'border' : '1px solid #ddd',
            'margin-bottom' : '10px'
        };

        // if (this.fieldIDs2JSON != undefined)
        // this.fieldIDs2JSON.forEach(function (element) {
        //     $('#' + element).on('change', $.proxy(this.fields2JSON, this));
        // });

        if ($('input[name="name_i18n"]').length > 0)
            $('input[name="name_i18n"]').on('change', $.proxy(this.swapMultilangImagesEdit, this));
        if ($('.language-selector label').length > 0)
        $('.language-selector label').on('click', $.proxy(this.swapMultilangImagesRead, this));
    };

    window.JSCustomBreadManager.prototype.swapMultilangImagesEdit = function (event) {
        $('[name="image_i18n"]').val(this.image_i18n);
        $('[name="preview_image_i18n"]').val(this.preview_image_i18n);

        var choosedLocale = $('.language-selector label.active').find('input').attr('id'),
            imageValue = $('[name="image_i18n"]'),
            previewImageValue = $('[name="preview_image_i18n"]');
        var imageContent = JSON.parse(imageValue.val()),
            previewImageContent = JSON.parse(previewImageValue.val());

        this.applyImage(imageValue, imageContent, choosedLocale, {'css' : this.css4EditImages});
        this.applyImage(previewImageValue, previewImageContent, choosedLocale, {'css' : this.css4EditImages});

        imageValue.siblings('img').attr('src', '/storage/' + imageContent[choosedLocale]);
        previewImageValue.siblings('img').attr('src', '/storage/' + previewImageContent[choosedLocale]);

        $('#locale2save').val(choosedLocale);
    };

    window.JSCustomBreadManager.prototype.swapMultilangImagesRead = function (event) {
        var choosedLocale = $(event.target).find('input').attr('id'),
            imageValue = $('#translate_image'),
            previewImageValue = $('#translate_preview_image');
        var imageContent = JSON.parse(imageValue.val()),
            previewImageContent = JSON.parse(previewImageValue.val());

        this.applyImage(imageValue, imageContent, choosedLocale, {'class' : 'img-responsive'});
        this.applyImage(previewImageValue, previewImageContent, choosedLocale, {'class' : 'img-responsive'});

        imageValue.siblings('img').attr('src', '/storage/' + imageContent[choosedLocale]);
        previewImageValue.siblings('img').attr('src', '/storage/' + previewImageContent[choosedLocale]);
    }

    window.JSCustomBreadManager.prototype.applyImage = function (imageValue, imageContent, choosedLocale, params) {
        if (imageValue.siblings('img').length == 0 &&
            imageContent[choosedLocale] != null && imageContent[choosedLocale].length > 0) {
            var newImgContainer = $('<img>');
            if (!!params['css'])
                newImgContainer.css(params['css']);
            if (!!params['class'])
                newImgContainer.addClass(params['class']);
            imageValue.after(newImgContainer);
        }

        if (imageValue.siblings('img').length > 0 &&
            (imageContent[choosedLocale] == null || imageContent[choosedLocale].length == 0)) {
            imageValue.siblings('img').remove();
        }
    };

    window.JSCustomBreadManager.prototype.fields2JSON = function(event) {
        var data2JSON = {},
            resultJSON = "";

        event.data.fieldIDs2JSON.forEach(function (element) {
            var name = $('#' + element).attr('name'),
                value = $('#' + element).val();
            data2JSON[name] = value;
        });

        console.log(data2JSON);
        resultJSON = JSON.stringify(data2JSON);
        $("#" + event.data.resultID2JSON).val(resultJSON);
        console.log(resultJSON);
    };

    MutationObserver = window.MutationObserver || window.WebKitMutationObserver;

    var trackChange = function(element) {
        var observer = new MutationObserver(function(mutations, observer) {
            if(mutations[0].attributeName == "value") {
                $(element).trigger("change");
            }
        });
        observer.observe(element, {
            attributes: true
        });
    };

    if ($('input[name="name_i18n"]').length > 0)
        trackChange( $('input[name="name_i18n"]')[0] );
})(window, jQuery)
