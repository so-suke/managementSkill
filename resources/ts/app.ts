import Vue from 'vue';
import bootstrap from './bootstrap';
import App from './components/App.vue';
import store from './store';
import router from './router/index';
import './plugins';
import vuetify from './plugins/vuetify'

bootstrap();

new Vue({
  el: '#app',
  router,
  store,
  vuetify,
  render: h => h(App)
});
