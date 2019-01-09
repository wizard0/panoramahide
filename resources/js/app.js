
//window.jQuery = window.$ = require('jquery');


/**
 * -------------------------------------------
 * Append laravel token
 * -------------------------------------------
 *
 */
window.Laravel = $('meta[name="csrf-token"]').attr('content');

$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': window.Laravel }
});

/**
 * -------------------------------------------
 * Lodash
 * -------------------------------------------
 *
 */
require('lodash/lodash.min.js');
window.toastr = require('toastr/build/toastr.min.js');

require('./plugins/form.js');
require('./plugins/cleave-masks.js');
