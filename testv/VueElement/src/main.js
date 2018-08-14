import Vue from 'vue'
import VueQuillEditor from 'vue-quill-editor' // 富文本插件
import VueAwesomeSwiper from 'vue-awesome-swiper' // vue-awesome-swiper

import 'normalize.css/normalize.css'// A modern alternative to CSS resets

import Element from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

import '@/styles/index.scss' // global css

import App from './App'
import router from './router'
import store from './store'

import i18n from './lang' // Internationalization
import './icons' // icon
import './errorLog'// error log
import './permission' // permission control
import './mock' // simulation data

import 'quill/dist/quill.core.css' // 富文本CSS
import 'quill/dist/quill.snow.css' // 富文本CSS
import 'swiper/dist/css/swiper.css' // swiper css

import * as filters from './filters' // global filters

import Icon from 'vue-awesome/components/Icon'

Vue.component('icon', Icon)

Vue.use(VueQuillEditor) // 富文本
Vue.use(VueAwesomeSwiper) // vue-awesome-swiper
Vue.use(Element, {
  size: 'medium', // set element-ui default size
  i18n: (key, value) => i18n.t(key, value)
})

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key])
})

Vue.config.productionTip = false

new Vue({
  el: '#app',
  router,
  store,
  i18n,
  template: '<App/>',
  components: { App }
})
