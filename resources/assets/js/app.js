
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css';
import axios from 'axios';
import VueAxios from 'vue-axios';

require('./bootstrap')

Vue.use(ElementUI)
Vue.use(VueAxios, axios);

// window.Vue = Vue
Vue.axios.defaults.headers.common = {
  'X-CSRF-TOKEN': window.Laravel.csrfToken,
  'X-Requested-With': 'XMLHttpRequest'
};
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example', require('./components/Example.vue'))
Vue.component('DouyuLotteryBanner',require('./components/DouyuLotteryBanner.vue'))
Vue.component('DouyuNavbar',require('./components/douyu/Navbar.vue'))
Vue.component('DouyuDrawLottery',require('./components/douyu/DrawLottery.vue'))

const app = new Vue({
    el: '#app'
})
