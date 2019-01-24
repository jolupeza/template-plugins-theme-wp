require('./bootstrap');

window.Vue = require('vue');
import store from './store';

import AppMessage from './components/Message/View';

const app = new Vue({
    el: "#app",
    components: {
        AppMessage
    },
    store
});
