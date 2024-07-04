import { getToken, removeToken } from "@/utils/authToken";
import store from "@/store";
import { MODULE_STORE, ROUTER_PATH, TYPE_USER } from "@/const";

export function auth(context, type) {
    const { next } = context;
    const token = getToken(type);
    if (token) {
        store.state[MODULE_STORE.AUTH.NAME].isAuthenticated = true;
        return next();
    }
    store.state[MODULE_STORE.AUTH.NAME].isAuthenticated = false;
    if (type === TYPE_USER.ADMIN) {
        removeToken(TYPE_USER.ADMIN);
        next({ path: ROUTER_PATH.LOGIN });
    }
    if (type === TYPE_USER.USER) {
        removeToken(TYPE_USER.USER);
        next({ path: ROUTER_PATH.LOGIN_CUSTOMER });
    }
}
export function guest(context, type) {
    const { next } = context;
    const token = getToken(type);
    if (!token) {
        store.state[MODULE_STORE.AUTH.NAME].isAuthenticated = false;
        return next();
    }
    if (type === TYPE_USER.ADMIN) next(ROUTER_PATH.ADMIN);
    if (type === TYPE_USER.USER) next(ROUTER_PATH.HOME);
}
