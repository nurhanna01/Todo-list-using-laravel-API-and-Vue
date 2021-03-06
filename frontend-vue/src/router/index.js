import Vue from "vue";

import VueRouter from "vue-router";

Vue.use(VueRouter);

const router = new VueRouter({
  routes: [
    {
      path: "/",
      name: "home",
      component: () => import(/* webpackChunkName: "Home" */ "@/views/Home"),
    },
    {
      path: "/register",
      name: "register",
      component: () =>
        import(/* webpackChunkName: "Auth" */ "@/views/auth/Register"),
    },
    {
      path: "/login",
      name: "login",
      component: () =>
        import(/* webpackChunkName: "Auth" */ "@/views/auth/Login"),
    },
    {
      path: "/profile",
      name: "profile",
      component: () =>
        import(/* webpackChunkName: "Profile" */ "@/views/Profile"),
    },
    {
      path: "/editprofile",
      name: "editprofile",
      component: () =>
        import(/* webpackChunkName: "EditProfile" */ "@/views/EditProfile"),
    },
    {
      path: "/addtodolist",
      name: "addList",
      component: () =>
        import(/* webpackChunkName: "AddList" */ "@/views/AddList"),
    },
  ],
  mode: "history",
});

export default router;
