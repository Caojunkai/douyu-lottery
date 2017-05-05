
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-default/index.css'

require('./bootstrap');

Vue.use(ElementUI);

window.Vue = Vue;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import DouyuLotteryBanner from './components/DouyuLotteryBanner.vue';

Vue.component('example', require('./components/Example.vue'));
Vue.component('DouyuLotteryBanner',DouyuLotteryBanner);

const app = new Vue({
    el: '#app'
});
