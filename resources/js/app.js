require('./bootstrap');

// Import modules...
import Vue from 'vue';

import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';

moment.locale("pt-br");

import moment from 'moment';
import store from './store';

store.dispatch('userStateAction');

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);

Vue.filter('formatDate', function (value){
    if(value) {
        return moment(value).format('DD/MM/YYYY HH:mm')
    }
});

const app = document.getElementById('app');

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);
