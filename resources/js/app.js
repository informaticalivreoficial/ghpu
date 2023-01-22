require('./bootstrap');

import store from './vuex/store'
import moment from 'moment';

window.Vue = require('vue').default;

/*
 * 
 * Components
 *  
 * */

import NotificationsComponent from './components//Notifications/Notifications.vue';
Vue.component('notifications', NotificationsComponent);
import NotificationComponent from './components//Notifications/Notification.vue';
Vue.component('notification', NotificationComponent);

Vue.filter('formatDate', function(value) {
    if (value) {
        return moment(String(value)).format('DD/MM hh:mm')
    }
});


// Vue.component('notifications', require('./components/notifications/Notifications.vue'));
// Vue.component('notification', require('./components/notifications/Notification'));

const app = new Vue({
    store,
    el: '#app',
});
