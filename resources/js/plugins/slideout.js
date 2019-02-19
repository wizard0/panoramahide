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
    console.log($(this).data('name'));
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
