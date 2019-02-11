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

/**
 * -------------------------------------------
 * Lodash
 * -------------------------------------------
 */
require('lodash/lodash.min.js');

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
 * -------------------------------------------
 * Slideout
 * -------------------------------------------
 */
const Slideout = require('slideout/dist/slideout.min');

window.slideout = new Slideout({
    'panel': document.getElementById('reader'),
    'menu': document.getElementById('reader-menu'),
    'padding': 300,
    'tolerance': 70
});
$('.toggle-button').click(function () {
    $('.nav-item[href="' + $(this).data('name') + '"]').tab('show');
    window.slideout.toggle();
});

function close(eve) {
    eve.preventDefault();
    window.slideout.close();
}

window.slideout
    .on('beforeopen', function (event) {
        this.panel.classList.add('panel-open');
        $('.hamburger-menu').toggleClass('animate');
    })
    .on('open', function () {
        this.panel.addEventListener('click', close);
    })
    .on('beforeclose', function () {
        this.panel.classList.remove('panel-open');
        $('.hamburger-menu').toggleClass('animate');
        this.panel.removeEventListener('click', close);
    });
/**
 * -------------------------------------------
 * simplebar
 * or "import SimpleBar from 'simplebar';" if you want to use it manually.
 * -------------------------------------------
 */
import 'simplebar';

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
