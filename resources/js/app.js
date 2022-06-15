require('./bootstrap');
import Vue from 'vue';
import {TabsPlugin, BTooltip, BootstrapVue} from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import VueFormulate from '@braid/vue-formulate'

Vue.use(TabsPlugin);
Vue.component('b-tooltip', BTooltip);
Vue.component('datatable', require('./components/DataTable.vue').default);
Vue.use(BootstrapVue)
Vue.use(VueFormulate, {
    classes: {
        outer: 'form-group',
        input: 'form-control',
        inputHasErrors: 'is-invalid',
        help: 'form-text text-muted',
        errors: 'list-unstyled text-danger'
    }
})


const app = new Vue({
    el: '#app',
});
