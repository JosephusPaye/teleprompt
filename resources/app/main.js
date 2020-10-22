import smoothscroll from 'smoothscroll-polyfill';
smoothscroll.polyfill();

import Vue from 'vue';
import App from './App.vue';

Vue.config.productionTip = false;
Vue.config.ignoredElements = ['trix-editor'];

const Root = Vue.extend(App);

const root = new Root({
  propsData: {
    backendData: window.backendData,
  },
});

root.$mount('#app');
