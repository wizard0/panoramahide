/**
 * -------------------------------------------
 * Append laravel token
 * -------------------------------------------
 *
 */
window.Laravel = $('meta[name="csrf-token"]').attr('content');

$.ajaxSetup({
    headers: {'X-CSRF-TOKEN': window.Laravel}
});

require('./reader.js');
/**
 * -------------------------------------------
 * Lodash
 * -------------------------------------------
 */
//require('lodash/lodash.min.js');

/**
 * -------------------------------------------
 * Toastr
 * -------------------------------------------
 */

window.toastr = require('toastr/build/toastr.min.js');
require('./plugins/notification.js');
if (window.toastrOptions !== undefined) {
    window.toastr.options = window.toastrOptions;
}
if (window.toastrNotification !== undefined) {
    window.notification.send(window.toastrNotification);
}

require('./helpers.js');
require('./plugins/form.js');
require('./plugins/callbacks.js');
require('./plugins/cleave-masks.js');
require('./main.js');

/**
 * Удалить .nav-hidden .hidden, чтобы при загрузке не светились
 */
$('.nav-hidden').removeClass('hidden');

/**
 * -------------------------------------------
 * tippy
 *
 * data-tippy-popover data-tippy-content='html'
 * -------------------------------------------
 */
import tippy from 'tippy.js'

tippy('[data-tippy-popover]', {
    interactive: true,
    theme: 'light',
    animateFill: false,
    //duration: [275, 250000],
});
