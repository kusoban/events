import Vue from 'vue'
import VueRouter from 'vue-router'

import store from '../store/index.js';

import Home from '../views/Home.vue'
import Login from '../views/auth/Login'
import Register from '../views/auth/Register'
import Events from '../views/events/Events'
import CreateEvent from '../views/events/Create'
import SingleEvent from '../views/events/SingleEvent'
import EventsSearchResults from '../views/events/SearchResults'
import CategoryEvents from '../views/events/CategoryEvents'
import FavoriteEvents from '../views/events/FavoriteEvents'
import RegisteredToEvents from '../views/events/RegisteredToEvents'

import axios from '../axios/api'

Vue.use(VueRouter)
function requireAuth (to, from, next) {
    let token = store.getters.user.accessToken;
    console.log(token)
    if(!token) return next('/login')

    if(store.getters.userIsLoggedIn) return next();

    axios.get('/me', {
      headers: {
        'Authorization': 'Bearer ' + token 
      }
    }).then(({data: {id, name, email}}) => {
      store.commit('setUser', {id, name, email, accessToken: token} )
      next();
    }).catch(err => {
      console.log('errr in me response', err.response)
      return next('/login')
    })

  // return next();
}

function skipIfLoggedIn(to, from, next) {
  // if(!store.getters.user.accessToken) return next('/login')
  return next()
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
  },
  {
    path: '/events/category/:category',
    name: 'category-events',
    component: CategoryEvents,
  },
  {
    path: '/events/favorites',
    name: 'favorite-events',
    beforeEnter: requireAuth,
    component: FavoriteEvents,
  },
  {
    path: '/events/registered',
    name: 'registered-to-events',
    beforeEnter: requireAuth,
    component: RegisteredToEvents,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEnter: skipIfLoggedIn
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    beforeEnter: skipIfLoggedIn
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
