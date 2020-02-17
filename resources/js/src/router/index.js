import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import store from '../store/index.js';

import axios from '../axios/api'

import Home from '../views/Home.vue'
import Login from '../views/auth/Login'
import Register from '../views/auth/Register'

import Events from '../views/events/Events'
import SingleEvent from '../views/events/SingleEvent'
import CreateEvent from '../views/events/Create'
import EditEvent from '../views/events/Edit'
import EventsSearchResults from '../views/events/SearchResults'
import CategoryEvents from '../views/events/CategoryEvents'
import FavoriteEvents from '../views/events/FavoriteEvents'
import MyEvents from '../views/events/MyEvents'
import RegisteredToEvents from '../views/events/RegisteredToEvents'
import Search from '../views/events/Search'
import EventsMap from '../views/Map'

import SinglePlace from '../views/places/SinglePlace'
import CreatePlace from '../views/places/CreatePlace'
import EditPlace from '../views/places/EditPlace'
import MyPlaces from '../views/places/MyPlaces'
import PlacesByType from '../views/places/PlacesByType'



function requireAuth (to, from, next) {
    if(store.getters.userIsLoggedIn) return next();
    let token = store.getters.user.accessToken;
    if(!token) return next('/login')


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


const routes = [
  {
    path: '/',
    name: 'home',
    component: Events
  },
  {
    path: '/places/create',
    name: 'create-place',
    beforeEnter: requireAuth,
    component: CreatePlace
  },
 
  {
    path: '/events/create',
    name: 'create-event',
    beforeEnter: requireAuth,
    component: CreateEvent
  },
  {
    path: '/events/favorites',
    name: 'favorite-events',
    beforeEnter: requireAuth,
    component: FavoriteEvents,
  },
  {
    path: '/places/my',
    name: 'my-places',
    beforeEnter: requireAuth,
    component: MyPlaces,
  },
  {
    path: '/places/type/:name',
    name: 'places-by-type',
    props: true,
    component: PlacesByType,
  },
  {
    path: '/events/my',
    name: 'my-events',
    beforeEnter: requireAuth,
    component: MyEvents,
  },
  {
    path: '/events/:id',
    name: 'show-event',
    component: SingleEvent
  },
  {
    path: '/events/:id/edit',
    name: 'edit-event',
    component: EditEvent
  },
  {
    path: '/places/:id',
    name: 'show-place',
    component: SinglePlace
  },
   {
    path: '/places/:id/edit',
    name: 'edit-place',
    beforeEnter: requireAuth,
    component: EditPlace
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
    path: '/events/registered',
    name: 'registered-to-events',
    beforeEnter: requireAuth,
    component: RegisteredToEvents,
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
    path: '/search',
    name: 'search',
    component: Search
  },
  {
    path: '/map',
    name: 'Map',
    component: EventsMap,
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
