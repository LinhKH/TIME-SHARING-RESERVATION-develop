<template>
    <div class="list__tour p-2.5">
        <div class="tour__panel flex justify-start items-center">
            <div class="tour__panel-search">
                <i class="fa fa-search" aria-hidden="true"></i>
                <span class="ml-1">{{ $t("tour_manager.tour_search") }}</span>
            </div>
            <div
                class="btn tour__panel-clearfix hover:bg-[#e6e6e6] border border-solid py-1.5 px-2.5 text-xs rounded text-[#333] bg-[#fff] border-[#ccc] ml-2.5 mr-1.5 py-1.5 px-3 border border-solid border-[#ccc] text-[#333] bg-[#fff] rounded cursor-pointer">
                <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                <span class="ml-1">{{ $t("tour_manager.tour_sort") }}</span>
            </div>
        </div>

        <div class="tour__panel-info inline-block xx-small my-3">
            <span
                class="btn hover:bg-[#e6e6e6] mr-1.5 py-1.5 px-3 border border-solid border-[#ccc] text-[#333] bg-[#fff] rounded cursor-pointer">{{
                $t("tour_manager.access_times") }}</span>
            <span
                class="btn hover:bg-[#e6e6e6] mr-1.5 py-1.5 px-3 border border-solid border-[#ccc] text-[#333] bg-[#fff] rounded cursor-pointer">{{
                $t("tour_manager.access_response") }}</span>
        </div>
        <TableAccess v-if="isDataLoaded" :dataTable="dataTable" :dataPageList="dataPageList" />
        <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total_page"
            @onBack="handleBackPage" @onNext="handleNextPage" />
    </div>
</template>

<script>
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import TableAccess from '@/components/TourManagement/Tour/TableAccess.vue'
import { ref, computed, watch, inject, onMounted } from "vue";
import { getAllListTourApi } from "@/api";
import Pagination from "@/components/Pagination/Pagination.vue";

export default {
    name: "TourList",
    components: { TableAccess, Pagination },
    setup() {
        const { t } = useI18n();
        const router = useRouter();
        const route = useRoute();
        const store = useStore();
        const toast = inject("$toast");
        const pagination = ref(null);
        const isDataLoaded = ref(false);
        
        const dataPageList = ref([]);
        const dataTable = [
            t("tour_manager.id_tour"),
            t("tour_manager.user_visit"),
            t("tour_manager.space_name"),
            t("tour_manager.space_content"),
            t("tour_manager.status"),
            t("tour_manager.action"),
            t("tour_manager.time_entry"),
        ];
        const pageCurrent = computed(() => {
            if (!route.query.page) {
                return PAGE_DEFAULT || 1;
            }
            return Number(route.query.page);
        });

        const getAllListTour = onMounted(async (page = PAGE_DEFAULT) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                getAllListTourApi(page).then((res) => {
                    dataPageList.value = res.data;
                    pagination.value = res.pagination;
                    isDataLoaded.value = true;
                });
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        });

        watch(pageCurrent, (page) => {
            if (route.path !== ROUTER_PATH.TOUR) {
                getAllListTour(page);
            }
        });

        // const getAllListTour = async (page = PAGE_DEFAULT) => {
        //     try {
        //         store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        //         const res = await getAllListTourApi(page);
        //         dataPageList.value = res.data;
        //         pagination.value = res.pagination;
        //         isDataLoaded.value = true;
        //     } catch (errors) {
        //         const error = errors.message || t("common.has_error");
        //         toast.error(error);
        //     } finally {
        //         store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        //     }
        // };
        const handleBackPage = (page) => {
            router.push(`${ROUTER_PATH.TOUR}?page=${page}`);
        };
        const handleNextPage = (page) => {
            router.push(`${ROUTER_PATH.TOUR}?page=${page}`);
        };

        // getAllListTour(pageCurrent);
        return { getAllListTour, ROUTER_PATH, dataTable, handleBackPage, handleNextPage, dataPageList, pagination, isDataLoaded };
    },
};
</script>

<style></style>
