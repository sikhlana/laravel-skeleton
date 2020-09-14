import Vue from "vue";
import axios from "axios";
import NProgress from "nprogress";

// Setting up axios...
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

axios.interceptors.request.use((config) => {
    NProgress.start();

    return Promise.resolve(config);
});

axios.interceptors.response.use((response) => {
    NProgress.done();

    return Promise.resolve(response);
}, (error) => {
    NProgress.done();

    return Promise.reject(error);
});

// Global components...
import Notification from "./components/Notification";
import Timestamp from "./components/Timestamp";
import Overlay from "./components/Overlay";

Vue.component('notification', Notification);
Vue.component('timestamp', Timestamp);
Vue.component('overlay', Overlay);

// Vue plugins...
import VueCookies from "vue-cookies";

Vue.use(VueCookies);
