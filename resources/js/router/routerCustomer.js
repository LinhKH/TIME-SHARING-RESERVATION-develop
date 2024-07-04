import { auth, guest } from "./middlewares";
import { ROUTER_PATH, TYPE_USER } from "@/const";

const RegisterCustomer = () => import("@/views/FormAuth/Register");
const LoginCustomer = () => import("@/views/FormAuth/Login");
const OverviewPageUser = () => import("@/views/OverviewPageUser");
const SpaceDetailClient = () => import("@/views/SpaceDetailClient");
const LayoutCustomer = () => import("@/components/Layouts/LayoutCustomer.vue");
const HomeCustomer = () => import("@/views/HomeCustomer/HomeCustomer.vue");

export default [
    // ROUTER_CUSTOMER
    {
        path: ROUTER_PATH.HOME,
        component: LayoutCustomer,
        children: [
            {
                path: ROUTER_PATH.EMPTY,
                component: HomeCustomer,
                meta: {
                    middleware: [(context) => auth(context, TYPE_USER.USER)],
                },
            },
            {
                path: ROUTER_PATH.OVERVIEW_USER,
                component: OverviewPageUser,
                meta: {
                    middleware: [(context) => auth(context, TYPE_USER.USER)],
                },
            },
            {
                path: `:id/${ROUTER_PATH.SPACE_DETAILS_CLIENT}`,
                component: SpaceDetailClient,
            },
        ],
    },
    {
        path: ROUTER_PATH.REGISTER_CUSTOMER,
        component: RegisterCustomer,
        meta: {
            middleware: [(context) => guest(context, TYPE_USER.USER)],
        },
    },
    {
        path: ROUTER_PATH.LOGIN_CUSTOMER,
        component: LoginCustomer,
        meta: {
            middleware: [(context) => guest(context, TYPE_USER.USER)],
        },
    },
];
