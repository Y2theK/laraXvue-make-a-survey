import { createRouter, createWebHistory } from "vue-router";
import DefaultLayout from "../components/DefaultLayout.vue";
import AuthLayout from "../components/AuthLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Survey from "../views/Survey.vue";
import SurveyView from "../views/SurveyView.vue";
import SurveyPublishView from "../views/SurveyPublishView.vue";
import Login from "../views/Login.vue";
import Register from "../views/Register.vue";
import store from "../store";
const routes = [
    {
        path: "/",
        redirect: "/dashboard",
        name: "Dashboard",
        component: DefaultLayout,
        meta: { requireAuth: true },
        children: [
            { path: "/dashboard", name: "Dashboard", component: Dashboard },
            { path: "/survey", name: "Survey", component: Survey },
            {
                path: "/survey/create",
                name: "SurveyCreate",
                component: SurveyView,
            },
            { path: "/survey/:id", name: "SurveyView", component: SurveyView },
        ],
    },
    {
        path: "/views/survey/:slug",
        name: SurveyPublishView,
        component: SurveyPublishView,
    },
    {
        path: "/auth",
        redirect: "/login",
        name: AuthLayout,
        component: AuthLayout,
        meta: { guestRoute: true },
        children: [
            {
                path: "/login",
                name: "Login",
                component: Login,
            },
            {
                path: "/register",
                name: "Register",
                component: Register,
            },
        ],
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    if (to.meta.requireAuth && !store.state.user.token) {
        next({ name: "Login" });
    } else if (store.state.user.token && to.meta.guestRoute) {
        next({ name: "Dashboard" });
    } else {
        next();
    }
});
export default router;
