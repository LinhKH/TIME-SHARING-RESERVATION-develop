<template>
    <div class="p-3">
        <div v-if="nameSpace" class="flex justify-between">
            <div class="w-[35%]">
                <div class="flex flex-wrap items-center">
                    <div class="flex mr-2">
                        <i class="fa fa-home text-[#337ab7] text-xl mr-2"></i>
                        <span class="text-[#337ab7] text-xl">{{ nameSpace }}</span>
                    </div>
                    <a :href="linkRoute.spaceDetailClient" target="_blank">
                        <span
                            class="group flex items-center bg-[#ffbd00] rounded-sm text-white cursor-pointer hover:bg-[#fff1cc] hover:text-[#ffbd00] px-2 btn-public">
                            <i class="fa fa-external-link text-white group-hover:text-[#ffbd00] mr-1"></i>
                            {{ $t("edit_space_page.view_public_page") }}
                        </span>
                    </a>
                </div>
                <div class="flex mt-2 mb-5">
                    <router-link :to="linkRoute.reservationRegister">
                        <div
                            class="text-white flex py-2 justify-center w-[250px] cursor-pointer hover:text-[#000] rounded bg-[#32ad38]">
                            {{ $t("edit_space_page.proxy_booking") }}
                        </div>
                    </router-link>
                </div>
            </div>
            <div class="w-[35%]">
                <div v-if="type === 'admin'"
                    class="w-full border border-solid border-[#666] rounded flex justify-between px-2 py-1 cursor-pointer"
                    @click="isShowBoxChangeStatus = !isShowBoxChangeStatus">
                    <div class="">
                        <template v-if="isPrivate">
                            <div class="font-bold text-[#666]">{{ $t("edit_space_page.status_private") }}</div>
                            <div class="font-bold text-[#737373]">{{ $t("edit_space_page.undisclosed") }}</div>
                        </template>
                        <template v-if="isPublic">
                            <div class="font-bold text-[#37a200]">{{ $t("edit_space_page.status_public") }}</div>
                            <div class="font-bold text-[#737373]">{{ $t("edit_space_page.released") }}</div>
                        </template>
                    </div>
                    <div class="">
                        <i class="fa fa-chevron-down text-[#37a200]" v-if="isPublic"></i>
                        <i class="fa fa-chevron-down text-[#737373]" v-if="isPrivate"></i>
                    </div>
                </div>
                <div class="w-full py-1 border-l border-r border-solid border-[#666] rounded shadow-lg"
                    v-if="isShowBoxChangeStatus && isPrivate">
                    <div class="px-4 py-2 hover:bg-[#eee] cursor-pointer"
                        @click="() => handleChangeStatus(STATUS_SPACE.PUBLIC)">
                        <div class="border border-solid border-[#37a200] text-[#37a200] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.change_to_publishing") }}
                        </div>
                        <div class="text-[#737373] mt-2">{{ $t("edit_space_page.released") }}</div>
                    </div>
                    <div class="px-4 py-2 bg-[#fff15e] cursor-pointer" @click="isShowBoxChangeStatus = false">
                        <div class="border border-solid border-[#666] text-[#666] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.currently_private") }}
                        </div>
                        <div class="text-[#666] mt-2">{{ $t("edit_space_page.undisclosed") }}</div>
                    </div>
                </div>
                <div class="w-full py-1 border-l border-r border-solid border-[#666] rounded shadow-lg"
                    v-if="isShowBoxChangeStatus && isPublic">
                    <div class="px-4 py-2 bg-[#fff15e] cursor-pointer" @click="isShowBoxChangeStatus = false">
                        <div class="border border-solid border-[#37a200] text-[#37a200] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.currently_open") }}
                        </div>
                        <div class="text-[#737373] mt-2">{{ $t("edit_space_page.released") }}</div>
                    </div>
                    <div class="px-4 py-2 hover:bg-[#eee] cursor-pointer"
                        @click="() => handleChangeStatus(STATUS_SPACE.ARCHIVED)">
                        <div class="border border-solid border-[#666] text-[#666] p-2 rounded font-bold text-sm">
                            {{ $t("edit_space_page.change_to_private") }}
                        </div>
                        <div class="text-[#666] mt-2">{{ $t("edit_space_page.undisclosed") }}</div>
                    </div>
                </div>
            </div>
        </div>
        <StepDetailOrder />
        <Suspense>
            <router-view :maxPlan="maxPlan" />
        </Suspense>
    </div>
</template>

<script>
import StepDetailOrder from "@/components/StepDetailOrder";
import { MODULE_STORE, ROUTER_PATH, STATUS_SPACE } from "@/const";
import { computed, inject, ref } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { getStatusSpace, updateStatusSpace } from "@/api";
import { useI18n } from "vue-i18n";

export default {
    name: "EditOrder",
    components: { StepDetailOrder },
    setup() {
        const store = useStore();
        const route = useRoute();
        const type = localStorage.getItem("type");
        const { t } = useI18n();
        const toast = inject("$toast");
        const statusSpace = ref("");
        const maxPlan = ref(0);
        const isPublic = computed(() => statusSpace.value == STATUS_SPACE.PUBLIC);
        const isPrivate = computed(() => statusSpace.value == STATUS_SPACE.ARCHIVED);
        const isShowBoxChangeStatus = ref(false);
        const nameSpace = computed(
            () => store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_NAME_SPACE}`]
        );
        const idSpace = route.params.id;
        const linkRoute = {
            spaceDetailClient: `${ROUTER_PATH.HOME}${idSpace}/${ROUTER_PATH.SPACE_DETAILS_CLIENT}`,
            reservationCalendar: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATION_CALENDAR}`,
            reservationRegister: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATION_REGISTER}?id=${idSpace}`,
        };
        const getStatusSpaceFromApi = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getStatusSpace(idSpace);
                statusSpace.value = res.data?.status;
                maxPlan.value = res.data?.max_rental_plans_count || 0;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        const handleChangeStatus = async (status) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                isShowBoxChangeStatus.value = false;
                await updateStatusSpace(idSpace, { status });
                toast.success(t("toast_message.update_success"));
                getStatusSpaceFromApi();
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        getStatusSpaceFromApi();
        return {
            nameSpace,
            linkRoute,
            isShowBoxChangeStatus,
            isPublic,
            isPrivate,
            STATUS_SPACE,
            handleChangeStatus,
            type,
            maxPlan,
        };
    },
};
</script>

<style scoped>
.btn-public {
    height: 20px;
}
</style>
