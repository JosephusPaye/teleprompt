import Vue from 'vue';
import * as emojicon from 'emojicon';
import App from './App.vue';

Vue.config.productionTip = false;

emojicon.set('📃');

const Root = Vue.extend(App);

const root = new Root({
  propsData: {
    backendData: window.backendData,
  },
});

root.$mount('#app');
