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
        <div v-if="isShowSuccess" class="border border-solid border-[#d6e9c6] bg-[#dff0d8] rounded p-[15px] mt-[5px]">
            <i class="fa fa-check text-[#3c763d] text-[16px] mr-[5px]"></i><span class="text-[#3c763d]">{{
                $t("tour_detail.approval_success") }}</span>
        </div>
        <div class="tour__panel-info inline-block xx-small my-3">
            <span
                class="btn hover:bg-[#e6e6e6] mr-1.5 py-1.5 px-3 border border-solid border-[#ccc] text-[#333] bg-[#fff] rounded cursor-pointer">{{
                    $t("tour_manager.access_times") }}</span>
            <span
                class="btn hover:bg-[#e6e6e6] mr-1.5 py-1.5 px-3 border border-solid border-[#ccc] text-[#333] bg-[#fff] rounded cursor-pointer">{{
                    $t("tour_manager.access_response") }}</span>
        </div>
        <TableAccess />
    </div>
</template>

<script>
import { onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import TableAccess from '@/components/TourManagement/Tour/TableAccess.vue'

import { ROUTER_PATH } from "@/const";
export default {
    name: "TourList",
    components: { TableAccess },
    setup() {
        return { ROUTER_PATH };
    },
};
</script>

<style></style>
