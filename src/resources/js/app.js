/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.EventVue = new Vue();

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

Vue.component('movies-list', require('./components/MoviesList.vue').default);

Vue.component('authentication', require('./components/Authentication.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import router from './routes';


window.sharedData = {
    user: null,
    app_name: '',
    root_url: '',
    isAuthenticated() {
        return this.user !== null;
    },
};
router.beforeEach((to, from, next) => {
    if (sharedData.isAuthenticated()) {
        if (to.path === '/auth') {
            next({path: '/movies'});
            return;
        }
    } else {
        if (['/', '/auth'].indexOf(to.path) === -1) {
            next({path: '/auth'});
            return;
        }
    }
    next();
});

const app = new Vue({
    el: '#app',
    data: {
        global: sharedData,
        selectedComponent: 'example',
    },
    mounted() {
        EventVue.$on('resetGlobal', () => {
            this.getGlobal();
        });
        this.getGlobal();
    },

    methods: {
        getGlobal() {
            axios.get('/api/v1/init_globals').then((response)=>{
                for (let field in response.data.data) {
                    this.global[field] = response.data.data[field];
                }
                if (this.isAuthenticated) {
                    this.$router.push('/movies');
                }
            });
        },
        isComponentActive(name) {
            return this.selectedComponent === name;
        },
    },

    computed: {
        isAuthenticated() {
            return this.global.isAuthenticated();
        },
    },

    router,
});
