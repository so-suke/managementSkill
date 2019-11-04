import Vue from 'vue'
import Router from 'vue-router'
import Meta from 'vue-meta'
import store from '../store';

Vue.use(Router)

const router = new Router({
  mode: 'hash',
  routes: [
    {
      path: "",
      component: (resovle: any) => import(
        `@src/views/auth/AuthWrapper.vue`
      ).then(resovle),
      redirect: { name: "Login" },
      meta: { requiresAuth: false },
      children: [
        {
          path: "login",
          name: "Login",
          component: (resovle: any) => import(
            `@src/views/auth/Login.vue`
          ).then(resovle),
          meta: { requiresAuth: false }
        },
        {
          path: "register",
          name: "Register",
          component: (resovle: any) => import(
            `@src/views/auth/Register.vue`
          ).then(resovle),
          meta: { requiresAuth: false }
        },
      ]
    },
    {
      path: "",
      name: "Admin Wrapper",
      component: (resovle: any) => import(
        `@src/views/admin/AdminWrapper.vue`
      ).then(resovle),
      redirect: { name: "Employee Profile", params: { id: store.state.authenticationModule.user.id } },
      meta: { requiresAuth: true },
      children: [
        {
          path: "your-profile",
          name: "Your Profile",
          redirect: { name: "Employee Profile", params: { id: store.state.authenticationModule.user.id } },
        },
        {
          path: "employee-list",
          name: "Employee List",
          component: (resovle: any) => import(
            `@src/views/admin/EmployeeList.vue`
          ).then(resovle),
          meta: { requiresAuth: true },
        },
        {
          path: "employee-profile/:id",
          component: (resovle: any) => import(
            `@src/views/admin/employeeProfile/wrapper.vue`
          ).then(resovle),
          meta: { requiresAuth: true },
          children: [
            {
              path: "",
              name: "Employee Profile",
              component: (resovle: any) => import(
                `@src/views/admin/employeeProfile/index.vue`
              ).then(resovle),
              meta: { requiresAuth: true },
            },
            {
              path: "update",
              name: "Employee Profile Update",
              component: (resovle: any) => import(
                `@src/views/admin/employeeProfile/update.vue`
              ).then(resovle),
              meta: { requiresAuth: true },
            },
          ]
        }
      ]
    },
  ],
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
    if (store.state.authenticationModule.isLogin === false) {
      next({
        name: 'Login',
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

export default router
