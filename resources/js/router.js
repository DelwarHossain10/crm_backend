import { createRouter, createWebHistory } from "vue-router";
// import home from "./components/frontend/home/index.vue";
// import login from "./components/frontend/login/index.vue";
const router = createRouter({
    history: createWebHistory(),
    routes: [
        // {
        //     path: "/",
        //     name: "Home",
        //     component: home,
        //     props: false,
        //     // component: () => import("./components/frontend/login/index.vue"),
        //     meta: {
        //         title: "Home",
        //     },
        // },
        // {
        //     path: "/login",
        //     name: "Login",
        //     props: false,
        //     // component: login,
        //     component: () => import("./components/frontend/login/index.vue"),
        //     meta: {
        //         title: "Login",
        //     },
        // },
        // {
        //     path: "/sign_up",
        //     name: "Sign_Up",
        //     component: () => import("./components/frontend/sign_up/index.vue"),
        //     props: false,
        //     // props: (route) => ({ data: { id: 12, name: 'John', age: 30 } })
        //     meta: {
        //         title: "Sign Up",
        //     },
        // },
        // {
        //     path: "/category/:slug",
        //     name: "Category",
        //     props: true,
        //     component: () => import("./components/frontend/category/index.vue"),
        //     meta: {
        //         title: "Category",
        //     },
        // },
    ],
});
router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title}`;
    next();
});
export default router;
