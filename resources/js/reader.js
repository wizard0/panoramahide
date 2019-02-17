/**
 * Сам Vue
 *
 * https://ru.vuejs.org/v2/guide/
 */
window.Vue = require('vue');

window.axios = require('axios');

Vue.prototype.$http = window.axios;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

/**
 * Импортируем компоненты
 */
import _ from 'lodash';
import vmodal from 'vue-js-modal';
import ReaderComponent from './components/ReaderComponent.vue';
import mixins from './mixins.js';

/**
 * -------------------------------------------
 * simplebar
 * or "import SimpleBar from 'simplebar';" if you want to use it manually.
 * -------------------------------------------
 */
import 'simplebar';

Vue.use(vmodal);

let VueScrollTo = require('vue-scrollto');

// You can also pass in the default options
Vue.use(VueScrollTo, {
    container: "#reader-panel",
    duration: 500,
    easing: "ease",
    offset: -100,
    force: true,
    cancelable: true,
    onStart: false,
    onDone: false,
    onCancel: false,
    x: false,
    y: true
});

Object.defineProperty(Vue.prototype, '$_', { value: _ });

/**
 * Регистрируем его на id="app-reader", если такой есть
 */
if (document.getElementById('app-reader')) {
    new Vue({
        el: '#app-reader',
        mixins: mixins,
        render: h => h(ReaderComponent),
        data: {
            options: {
                modal: {
                    active: null,
                    tmpActive: null,

                    readerCode: 'readerCode-modal',
                    readerOnline: 'readerOnline-modal',
                },
            }
        },
    });
    require('./plugins/slideout');
}
