// отправка ajax запроса
function ajax(url, data, callback, callbackError, params)
{

    if (callbackError == undefined) {
        callbackError = function(error) {
            notice(error, 'error');
        }
    }
    if (params == undefined) params = {};
    var ajaxParams = {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        method: params.method || 'POST',
        dataType: 'json',
        data: data || {},
        success: function(res) {
            if (res.error) {
                console.log(res);
                if (res.errorCode == 'need_authorize') {
                    $('#login-modal').modal('show');
                }
                callbackError(res.error);
            } else {
                callback(res);
            }
        },
        error: function(a, b, c) {
            callbackError(a.status + ' ' + a.statusText);
        }
    }
    if (params.file) {
        ajaxParams.processData = false;
        ajaxParams.contentType = false;
    }
    $.ajax(ajaxParams);
    return false;
}

// уведомление
// function notice(msg, type, object, params)
// {
//     if (params == undefined) params = {};
//     params = {
//         position: params.position || 'right bottom',
//     }
//     switch(type) {
//         case 'error':
//             params.className = 'error';
//             break;
//         case 'success':
//         default:
//             params.className = 'success';
//             break;
//     }
//     if ($(window).width() < 768) {
//         params.position = 'right bottom';
//         $.notify(msg, params);
//     } else if (object == undefined) {
//         $.notify(msg, params);
//     } else {
//         object.notify(msg, params);
//     }
// }

// загрузить в контейнер to данные по url
function load(url, to, callback)
{
    $(to).html('<div class="row justify-content-center align-items-center"><img src="/loader.svg"/></div>');
    if (callback == undefined) {
        callback = function(){

        }
    }
    $(to).load(url, callback);
}
