import Vue from 'vue';
import bootstrap from './bootstrap';
import App from './components/App.vue';
import { extend } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import * as ja from "vee-validate/dist/locale/ja";
import vuetify from './plugins/vuetify'
import router from './router/index';
import store from './store';
import './plugins';

bootstrap();

for (let rule in rules) {
  extend(rule, {
    ...(rules as any)[rule],
    message: ja.messages[rule]
  });
}

new Vue({
  el: '#app',
  router,
  store,
  vuetify,
  render: h => h(App)
});
