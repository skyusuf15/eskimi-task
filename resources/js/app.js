// Axios & Echo global
require('./bootstrap');

/* Core */
import Vue from 'vue'
import Buefy from 'buefy'
import VueSilentbox from "vue-silentbox";

/* Router & Store */
import router from './router'
import store from './store'

/* Vue. Main component */
import App from './App.vue'


/* Collapse mobile aside menu on route change */
router.afterEach(() => {
  store.commit('asideMobileStateToggle', false)
})

Vue.config.productionTip = false

Vue.use(VueSilentbox)

/* Main component */
Vue.component('App', App)

/* Buefy */
Vue.use(Buefy)

/* This is main entry point */

new Vue({
  store,
  router,
  render: h => h(App),
  mounted() {
    document.documentElement.classList.remove('has-spinner-active')
  }
}).$mount('#app')
