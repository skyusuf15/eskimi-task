import Vue from 'vue'
import Router from 'vue-router'
import Home from './views/Home.vue'

Vue.use(Router)

export default new Router({
  base: process.env.BASE_URL,
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/adverts/index',
      name: 'adverts.index',
      component: () => import('./views/Adverts/AdvertsIndex.vue'),
    },
    {
      path: '/adverts/',
      name: 'adverts.new',
      component: () => import('./views/Adverts/AdvertsForm.vue'),
    },
    {
      path: '/adverts/:id',
      name: 'adverts.edit',
      component: () => import('./views/Adverts/AdvertsForm.vue'),
      props: true
    },
  ],
  scrollBehavior (to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { x: 0, y: 0 }
    }
  }
})
