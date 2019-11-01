/**
 * Vue Router
 *
 * @library
 *
 * https://router.vuejs.org/en/
 */

// Lib imports
import Vue from 'vue'
import VueAnalytics from 'vue-analytics';
import Router from 'vue-router'
import Meta from 'vue-meta'
// Routes
import paths from './paths'
import * as process from 'process';
import { AuthenticationModule } from "../store/module/authentication";

function route(path: string, view: string, name: string, meta: { requiresAuth: boolean }) {
  return {
    name: name || view,
    path,
    component: (resovle: any) => import(
      `@src/views/${view}.vue`
    ).then(resovle),
    meta,
  }
}

Vue.use(Router)

// console.log(paths.map(path => route(path.path, path.view as string, path.name as string, path.meta as { requiresAuth: boolean })))

// Create a new router
const router = new Router({
  mode: 'hash',
  routes: paths.map(path => route(path.path, path.view as string, path.name as string, path.meta as { requiresAuth: boolean })),
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    }
    if (to.hash) {
      return { selector: to.hash }
    }
    return { x: 0, y: 0 }
  }
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (AuthenticationModule.isLogin === false) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next();
  }
});

Vue.use(Meta)

// Bootstrap Analytics
// Set in .env
// https://github.com/MatteoGabriele/vue-analytics
// if (process.env.GOOGLE_ANALYTICS) {
//   Vue.use(VueAnalytics, {
//     id: process.env.GOOGLE_ANALYTICS,
//     router,
//     autoTracking: {
//       page: process.env.NODE_ENV !== 'development'
//     }
//   })
// }

export default router
