import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/auth/Login'
import Register from '../views/auth/Register'
import Events from '../views/events/Events'
import CreateEvent from '../views/events/Create'
import SingleEvent from '../views/events/SingleEvent'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Events
  },
  {
    path: '/event/:id',
    name: 'show-event',
    component: SingleEvent
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
    path: '/event/create',
    name: 'create-event',
    component: CreateEvent
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
