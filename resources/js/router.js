import VueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(VueRouter);
import store from './store';

import Login from './components/auth/Login'
import Register from './components/auth/Register'
import Events from './components/events/Events';
import CreateEvent from './components/events/CreateEvent';
import EventLayout from './layouts/EventLayout';


const routes = [
    {
        name: 'home',
        path: '/',
        component: Events,
    },
    {
        name: 'events',
        path: '/events',
        component: Events
    }, 
    {
        name: 'login',
        path: '/login',
        component: Login
    }, 
    {
        name: 'register',
        path: '/register',
        component: Register,
    }, 
    {
        path: '/event',
        component: EventLayout,
        children: [
            {
                path: 'create',
                component: CreateEvent,
                beforeEnter: (to, from, next) => {
                    console.log(store.state.user);
                    if(!store.state.user.email) {
                        return next('login')
                    }
                    next()
                }
            }
        ]
    }
];

export default new VueRouter({
    mode: 'history',
    base: __dirname,
    routes,
})


