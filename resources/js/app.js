
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

const Slideout = require('slideout/dist/slideout.min');
const SmoothScroll = require('smooth-scroll/dist/smooth-scroll.min');

let scroll = new SmoothScroll('a[href*="#"]');

import 'simplebar'; // or "import SimpleBar from 'simplebar';" if you want to use it manually.

let slideout = new Slideout({
    'panel': document.getElementById('body'),
    'menu': document.getElementById('menu'),
    'padding': 300,
    'tolerance': 70
});
$('.toggle-button').click(function () {
    $('.nav-item[href="' + $(this).data('name') + '"]').tab('show');
    slideout.toggle();
});
function close(eve) {
    eve.preventDefault();
    slideout.close();
}
slideout
    .on('beforeopen', function(event) {
        this.panel.classList.add('panel-open');
        $('.hamburger-menu').toggleClass('animate');
        console.log(event);
    })
    .on('open', function() {
        this.panel.addEventListener('click', close);
    })
    .on('beforeclose', function() {
        this.panel.classList.remove('panel-open');
        $('.hamburger-menu').toggleClass('animate');
        this.panel.removeEventListener('click', close);
    });

/**
 * Удалить .nav-hidden .hidden, чтобы при загрузке не светились
 */
$('.nav-hidden').removeClass('hidden');



import tippy from 'tippy.js'

tippy('[data-tippy-popover]', {
    interactive : true,
    theme: 'light',
    animateFill: false,
    //duration: [275, 250000],
});
