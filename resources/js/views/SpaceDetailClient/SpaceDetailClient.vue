<template>
    <div>
        <div class="max-w-[1200px] h-full m-auto items-end relative">
            <div class="max-w-[1200px] w-full h-[80px] fixed top-0 z-10">
                <div class="py-4 bg-[#ffffff] border-b-2 border-solid border-[#eaeaea]">
                    <img :src="logoTimeSharing" alt="logoTimeSharing" class="w-1/6 h-1/6 object-contain" />
                </div>
            </div>
            <div class="w-full h-full pt-[80px]">
                <div class="alert-box alert-danger"
                    v-if="space_status != STATUS_SPACE.PUBLIC && space_status != STATUS_SPACE.PENDING">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle-thin fa-stack-2x text-[#a94442]"></i>
                        <i class="fa-stack-1x fa fa-book text-[#a94442]"></i>
                    </span>
                    {{ $t("public_page.closed_space") }}
                </div>
                <div class="w-full h-full text-[20px] mt-2">
                    <span>{{ idText }}</span>
                    <span>{{ spaceTitle }}</span>
                </div>
                <div class="w-full h-full flex">
                    <main-space-detail-client class="w-[66.67%] h-full lg:w-[66.67%] sm:w-full"
                        :information="spaceInformation" :listSpace="listSpace" />
                    <side-fix-space-detail-client v-if="space_status == STATUS_SPACE.PUBLIC"
                        class="w-[33.33%] h-full sticky top-[80px] lg:block sm:hidden"
                        :information="spaceInformation" />
                </div>
            </div>
        </div>
        <root-space-detail-client />
    </div>
</template>

<script>
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
import SideFixSpaceDetailClient from "./child/SideFixSpaceDetailClient.vue";
import MainSpaceDetailClient from "./child/MainSpaceDetailClient.vue";
import RootSpaceDetailClient from "./child/RootSpaceDetailClient.vue";
import { getPublicSpacePreview, getListPublicSpacePreview } from "@/api";
import { computed, inject } from "vue";
import { MODULE_STORE, STATUS_SPACE } from "@/const";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
export default {
    components: { MainSpaceDetailClient, SideFixSpaceDetailClient, RootSpaceDetailClient },
    name: "SpaceDetailClient",
    setup() {
        const route = useRoute();
        const store = useStore();
        const idSpace = route.params.id;
        const idText = `（ID:${idSpace}）`;
        const toast = inject("$toast");
        const spaceInformation = computed(() => store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/getPreviewedSpace`]);
        const listSpace = computed(() => store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/getListPreviewedSpace`]);
        const spaceTitle = computed(() => spaceInformation.value?.general?.general_basic_space_name_ja || "");
        const space_status = computed(() => spaceInformation.value?.status || STATUS_SPACE.PENDING);
        const initUpdate = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getPublicSpacePreview(idSpace);
                if (res?.data) {
                    store.commit(`${MODULE_STORE.RENTAL_SPACES.NAME}/SET_PREVIEWED_SPACE`, res.data);
                }
                const params = `?limit=4&status=published`;
                const res2 = await getListPublicSpacePreview(params);
                if (res2?.data) {
                    store.commit(`${MODULE_STORE.RENTAL_SPACES.NAME}/SET_LIST_PREVIEWED_SPACE`, res2.data);
                }
            } catch (error) {
                toast.error(error.msg);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        initUpdate();
        return {
            MODULE_STORE,
            logoTimeSharing,
            idText,
            store,
            spaceTitle,
            spaceInformation,
            space_status,
            STATUS_SPACE,
            listSpace,
        };
    },
};
</script>

<style lang="scss" scoped>
.alert-box {
    z-index: 12;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    padding: 5px 0;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 700;

    &.alert-danger {
        color: #a94442;
        background-color: #f2dede;
        border-color: #ebccd1;
    }
}
</style>
