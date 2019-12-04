import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',
        component: require('./components/ExampleComponent').default,
    },
    {
        path: '/auth',
        component: require('./components/Authentication').default,
    },
    {
        path: '/movies',
        component: require('./components/MoviesList').default,
    },
    {
        path: '/movies/:id',
        name: 'movie_edit',
        component: require('./components/MovieEdit').default,
    },
];

export default new VueRouter({
    routes,
});