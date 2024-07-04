import { createRouter, createWebHistory } from "vue-router";
import routerAdmin from "./routerAdmin";
import routerCustomer from "./routerCustomer";

const routes = [...routerAdmin, ...routerCustomer];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
const middlewarePipeline = (context, middleware, index) => {
    const nextMiddleware = middleware[index];
    if (!nextMiddleware) {
        return context.next;
    }
    return () => {
        const nextPipeline = middlewarePipeline(context, middleware, index + 1);
        nextMiddleware({ ...context, next: nextPipeline });
    };
};
router.beforeEach((to, from, next) => {
    if (!to.meta.middleware) {
        return next();
    }
    const { middleware } = to.meta;
    const context = { to, from, next };
    return middleware[0]({
        ...context,
        next: middlewarePipeline(context, middleware, 1),
    });
});
export default router;
