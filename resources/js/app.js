import Vue from "vue";
import Application from "./Application";

require('./bootstrap')

const app = new Vue({
    ...Application,
});

app.$mount('#app');
