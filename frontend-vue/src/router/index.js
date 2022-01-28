import Vue from 'vue'

import VueRouter from 'vue-router'

Vue.use(VueRouter)

const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: () =>
                import( /* webpackChunkName: "Auth" */ "@/views/Home"),
        },
        // {
        //     path: '/register',
        //     name: 'register',
        //     component: () =>
        //         import( /* webpackChunkName: "Auth" */ "@/views/auth/Register"),
        // },
        {
            path: '/login',
            name: 'login',
            component: () =>
                import( /* webpackChunkName: "Auth" */ "@/views/auth/Login"),
        }
    ],
    mode: 'history',
})

export default router