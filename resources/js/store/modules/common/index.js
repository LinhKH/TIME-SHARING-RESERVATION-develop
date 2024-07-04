import { MODULE_STORE } from "@/const";

const common = {
    namespaced: true,
    state() {
        return {
            isLoadingPage: false,
        };
    },
    getters: {
        [MODULE_STORE.COMMON.GETTERS.GET_IS_LOADING](state) {
            return state.isLoadingPage;
        },
    },
};
export default common;
