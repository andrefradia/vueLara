
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

//Custom Gate JS file
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.type);

//MomentJS
import moment from 'moment';

//VFrom
import { Form, HasError, AlertError } from 'vform'
window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)


//Notification for form error validation (Custom component)
Vue.component('form-error', require('./components/form-error/FormError.vue').default)

//Custom 404 error page
Vue.component('error-page',require('./components/PageNotFound.vue').default)

//VueRouter
import VueRouter from 'vue-router'
Vue.use(VueRouter)

let routes = [
  { path: '/dashboard', component: require('./components/Dashboard.vue').default },
  { path: '/users', component: require('./components/Users.vue').default },
  { path: '/profile', component: require('./components/Profile.vue').default },
  { path: '/developer', component: require('./components/Developer.vue').default }
]

const router = new VueRouter({
	mode: 'history',
	routes // short for `routes: routes`
})


//VueFilter
Vue.filter('upText', function(text){
	return text.charAt(0).toUpperCase() + text.slice(1);
});

Vue.filter('toDate', function(dateIn){
	return moment(dateIn).format('MMMM Do YYYY');
})


//VueProgressBar
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})


//SweetAlert2
import Swal from 'sweetalert2'
window.Swal = Swal

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000
});

window.toast = Toast



//Vue Object For Emit Event
window.Fire = new Vue();



//Testing Laravel Passport Purpose
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);


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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
