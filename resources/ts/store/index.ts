import Vue from 'vue';
import Vuex from 'vuex';
import createPersistedState from "vuex-persistedstate";
import authenticationModule from "@modules/authentication";

Vue.use(Vuex);
const store = new Vuex.Store({
  state: {},
  modules: {
    authenticationModule
  },
  strict: true,
  plugins: [createPersistedState({
    key: 'AuthenticationModule',
    paths: ['authenticationModule.isLogin', 'authenticationModule.user'],
    storage: window.sessionStorage
  })]
});
// const store = new Vuex.Store({
// });
export default store;

