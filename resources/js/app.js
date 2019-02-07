
//window.jQuery = window.$ = require('jquery');

import HELPER from "./helpers";

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
require('./helpers.js');
require('./plugins/form.js');
require('./plugins/callbacks.js');
require('./plugins/cleave-masks.js');
require('./main.js');


import tippy from 'tippy.js'

tippy('[data-tippy-popover]', {
    interactive : true,
    theme: 'light',
    animateFill: false,
    //duration: [275, 250000],
});
