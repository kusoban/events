import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store/index.js';

import Home from '../views/Home.vue'
import Login from '../views/auth/Login'
import Register from '../views/auth/Register'
import Events from '../views/events/Events'
import CreateEvent from '../views/events/Create'
import SingleEvent from '../views/events/SingleEvent'
import EventsSearchResults from '../views/events/SearchResults';
Vue.use(VueRouter)
function requireAuth (to, from, next) {
  if(!store.getters.userIsLoggedIn) return next('/login');
  return next();
}

const routes = [
  {
    path: '/',
    name: 'home',
    component: Events
  },
  {
    path: '/event/create',
    name: 'create-event',
    beforeEnter: requireAuth,
    component: CreateEvent
  },
  {
    path: '/event/:id',
    name: 'show-event',
    component: SingleEvent
  },
  {
    path: '/events/search-results',
    name: 'events-search-results',
    component: EventsSearchResults,
    props: true,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router
