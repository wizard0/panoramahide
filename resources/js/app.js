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
 * Lodash
 * -------------------------------------------
 */
window.toastr = require('toastr/build/toastr.min.js');

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

if (window.modal !== undefined && window.modal.active !== null) {
    //$('#' + window.modal.active).modal('show');
}
