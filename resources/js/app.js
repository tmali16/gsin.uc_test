/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import VueCountdown from '@chenfengyuan/vue-countdown';
var cookie = require('vue-cookie');
Vue.use(cookie);

import {BootstrapVue, BootstrapVueIcons, ToastPlugin}  from 'bootstrap-vue'
import VueHtmlToPaper from 'vue-html-to-paper';
Vue.use(BootstrapVue )
Vue.use(BootstrapVueIcons)
Vue.use(ToastPlugin)

Vue.use(require('vue-moment'));

const options = {
    name: '_blank',
    specs: [
      'fullscreen=no',
      'titlebar=yes',
      'scrollbars=yes'
    ],
    styles: [
      'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css',
      '/public/css/print.css'
    ]
  }
  
Vue.use(VueHtmlToPaper, options);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('create-question', require('./components/admin/CreateQuestion.vue').default);
Vue.component('show-question', require('./components/Question.vue').default);
Vue.component('test-vue', require('./components/Test.vue').default);
Vue.component('test-list', require('./components/TestList.vue').default);
Vue.component('test-content', require('./components/TestContent.vue').default);
Vue.component('questions-list', require('./components/Question_list.vue').default);
Vue.component('questions-edit', require('./components/QuestionEdit.vue').default);
Vue.component('candidate-vue', require('./components/Candidate.vue').default);
Vue.component('result-vue', require('./components/Result.vue').default);
Vue.component('user-vue', require('./components/admin/User.vue').default);
Vue.component('settings-vue', require('./components/admin/Settings.vue').default);
Vue.component('role-vue', require('./components/admin/Role.vue').default);
Vue.component('permission-vue', require('./components/admin/Permission.vue').default);
Vue.component('dashboard-vue', require('./components/admin/Dashboard.vue').default);
Vue.component('progress-vue', require('./components/TestProgress.vue').default);
Vue.component('settings-edit', require('./components/admin/SettingsEdit.vue').default);


Vue.component(VueCountdown.name, VueCountdown);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const app = new Vue({
    el: '#app',
});
