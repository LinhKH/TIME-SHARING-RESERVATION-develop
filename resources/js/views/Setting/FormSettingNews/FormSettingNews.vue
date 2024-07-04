<template>
    <div class="font-serif" v-if="isShowAddNew === false">
        <div class="text-end mb-[8px]">
            <button @click="handleAddNew"
                class="bg-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all">
                <i class="fa fa-plus text-[14px] text-[#fff] mr-[5px]"></i>
                <span class="text-[14px] text-[#fff]">{{ $t("form_setting_news.add_new") }}</span>
            </button>
        </div>
        <div>
            <table class="table w-full border border-solid border-[#ccc] border-collapse" cellspacing="1">
                <thead>
                    <tr>
                        <th class="border border-solid border-[#ccc] border-collapse p-[8px] text-start"
                            v-for="(NewHeaderItem, index) in settingNewHeader" scope="col" :key="index">
                            {{ NewHeaderItem }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(newItem, index) in listNews" :key="index"
                        :class="[newItem.active === 1 ? 'bg-[#fcf4d8]' : '']">
                        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
                            <span @click="() => handleActive(newItem.id)"
                                class="text-[#337ab7] cursor-pointer hover:underline">{{
                                    newItem.title
                                }}</span>
                        </td>
                        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start text-[#337ab7] main-wrapper"
                            scope="row">
                            <span @click="() => handleActive(newItem.id)" class="cursor-pointer"
                                v-html="newItem.content"></span>
                        </td>
                        <td class="border border-solid border-[#ccc] border-collapse p-2.5 text-start" scope="row">
                            <span @click="() => handleActive(newItem.id)"
                                class="text-[#337ab7] cursor-pointer hover:underline">{{
                                    formatDate(newItem.date_time)
                                }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total_page"
        @onBack="handleBackPage" @onNext="handleNextPage" />
</template>

<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, watch, inject } from "vue";
import { getListSettingNewApi } from "@/api";
import Pagination from "@/components/Pagination";
export default {
    name: "FormSettingNews",
    components: { Pagination },
    setup() {
        const { t } = useI18n();
        const toast = inject("$toast");
        const router = useRouter();
        const route = useRoute();
        const store = useStore();
        const isShowAddNew = ref(false);
        const listNews = ref([]);
        const pagination = ref(null);
        const deleteOfUpdate = ref(false);
        const itemNew = ref();

        const settingNewHeader = [
            t("form_setting_news.title"),
            t("form_setting_news.content"),
            t("form_setting_news.date"),
        ];
        const settingNewList = [
            {
                id: 1,
                newTitle: "test123",
                newContent: "123",
                newDate: "2020-05-30",
            },
            {
                id: 2,
                newTitle: "test123",
                newContent: "123",
                newDate: "2020-05-30",
            },
            {
                id: 3,
                newTitle: "test123",
                newContent: "123",
                newDate: "2020-05-30",
            },
        ];
        const handleAddNew = () => {
            router.push(`${ROUTER_PATH.NEWS_ADD}`);
        };
        const pageCurrent = computed(() => {
            if (!route.query.page) {
                return PAGE_DEFAULT || 1;
            }
            return Number(route.query.page);
        });
        watch(pageCurrent, (page) => {
            if (route.path !== ROUTER_PATH.TOUR) {
                getAllSettingNew(page);
            }
        });
        const handleBackPage = (page) => {
            router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
        };
        const handleNextPage = (page) => {
            router.push(`${ROUTER_PATH.CONFIGURATION}?page=${page}`);
        };
        const getAllSettingNew = async (page = PAGE_DEFAULT) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getListSettingNewApi(page);
                listNews.value = res.data;
                pagination.value = res.pagination;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const handleActive = (id) => {
            router.push(`${ROUTER_PATH.NEWS_ADD}?id=${id}`);
        };
        const formatDate = (valueDate) => {
            if (valueDate) {
                const date = new Date(valueDate);
                let month = "" + (date.getMonth() + 1);
                let day = "" + date.getDate();
                const year = date.getFullYear();

                return `${year}-${month < 10 ? `0${month}` : month}-${day < 10 ? `0${day}` : day}`;
            }
        };

        getAllSettingNew(pageCurrent);
        return {
            content: "",
            settingNewHeader,
            settingNewList,
            handleAddNew,
            isShowAddNew,
            listNews,
            pagination,
            getAllSettingNew,
            handleBackPage,
            handleNextPage,
            handleActive,
            deleteOfUpdate,
            itemNew,
            formatDate,
        };
    },
};
</script>

<style scoped>
.main-wrapper:deep(p) {
    color: #337ab7;
}

.main-wrapper:deep(p):hover {
    text-decoration: underline;
}
</style>
