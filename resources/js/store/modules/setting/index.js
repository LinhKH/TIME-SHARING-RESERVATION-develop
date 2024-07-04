import { MODULE_STORE } from "@/const";
import { getListPurposeOfUseByCategory } from "@/api";

const listCategoryPurposeOfUse = [
    {
        id: "use-purpose-category",
        label: "利用目的",
        active: true,
    },
];
async function getListPurposeOfUseByCategoryFromApi() {
    const res = await getListPurposeOfUseByCategory("use-purpose-category", 1);
    res.data.forEach((element) => {
        listCategoryPurposeOfUse.push({
            id: element.category_id + "-" + element.id,
            label: element.title_ja,
            active: false,
        });
    });
}

const setting = {
    namespaced: true,
    state() {
        return {
            listCategoryPurposeOfUse: [],
        };
    },
    getters: {
        [MODULE_STORE.SETTING.GETTERS.GET_LIST_CATEGORY_PURPOSE_OF_USE](state) {
            return state.listCategoryPurposeOfUse;
        },
    },
    mutations: {
        setListCategoryPurposeOfUse(state, list) {
            list.forEach((item) => {
                if (!state.listCategoryPurposeOfUse.find((element) => element.id == item.id))
                    state.listCategoryPurposeOfUse.push(item);
            });
        },
    },
    actions: {
        [MODULE_STORE.SETTING.ACTIONS.SET_ACTIVE_CATEGORY_PURPOSE]({ state }, payload) {
            state.listCategoryPurposeOfUse.forEach((item) => {
                if (item.id == payload) {
                    item.active = true;
                } else {
                    item.active = false;
                }
            });
        },
        async setListCategoryPurposeOfUse({ commit }) {
            await getListPurposeOfUseByCategoryFromApi();
            commit("setListCategoryPurposeOfUse", listCategoryPurposeOfUse);
        },
    },
};
export default setting;
