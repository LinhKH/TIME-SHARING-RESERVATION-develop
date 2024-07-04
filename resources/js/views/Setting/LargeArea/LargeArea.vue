<template>
    <div class="font-serif">
        <div class="text-end mb-[8px]">
            <button @click="handleAddNew"
                class="bg-[#ffbd00] px-[12px] py-[6px] rounded shadow-[0_1px_1px_0_#a4966e] translate-y-0 hover:translate-y-1 transition-all">
                <i class="fa fa-plus text-[14px] text-[#fff] mr-[5px]"></i>
                <span class="text-[14px] text-[#fff]">{{ $t("form_setting_news.add_new") }}</span>
            </button>
        </div>
        <tree :tree-data="tree"></tree>
    </div>
</template>

<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, watch, inject } from "vue";
import { getListLargeArea } from "@/api";
import Tree from "./Tree";

export default {
    name: "LargeArea",
    components: { Tree },
    setup() {
        const { t } = useI18n();
        const toast = inject("$toast");
        const router = useRouter();
        const route = useRoute();
        const store = useStore();
        const listLargeArea = ref([]);
        const tree = ref([]);
        const handleAddNew = () => {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.LARGE_AREA_DETAIL}`);
        };
        const handleDatailLarge = (id) => {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.LARGE_AREA_DETAIL}?id=${id}`);
        };
        const listAllLargeArea = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getListLargeArea();
                tree.value = res.data;
                listLargeArea.value = res.data;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        listAllLargeArea();

        return {
            listLargeArea,
            handleAddNew,
            handleDatailLarge,
            tree,
        };
    },
};
</script>

<style></style>
