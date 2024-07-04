<template>
    <div class="flex w-full h-[50px] border border-solid border-[#dbdbdb] border-t-0 border-l-0 border-r-0 bg-white">
        <div class="w-[14%] h-full">
            <Logo class="w-full h-full" />
        </div>
        <div class="w-[86%] flex items-center justify-end">
            <div v-show="isShowHeader" class="w-full flex items-center">
                <div class="flex items-center mr-3">
                    <FormKit type="text" :label="$t('header.space_id_search')" value="" placeholder="ID"
                        wrapper-class="flex" label-class=""
                        inner-class="mx-1 border border-solid  rounded border-[#4F4F4F]"
                        input-class="w-[100px] h-6 px-2" v-model="spaceId" />
                    <button @click="handleSpaceId"
                        class="bg-[#ebeaea] hover:bg-[#d6d5d5] border border-solid rounded border-[#4F4F4F] px-1 h-6">
                        {{ $t("header.search") }}
                    </button>
                </div>
                <div class="flex items-center mr-3">
                    <FormKit type="text" :label="$t('header.reservation_id_search')" value="" placeholder="ID"
                        wrapper-class="flex" label-class=""
                        inner-class="mx-1 border border-solid  rounded border-[#4F4F4F]"
                        input-class="w-[100px] h-6 px-2" v-model="reservationId" />
                    <button @click="handleReservationId"
                        class="bg-[#ebeaea] hover:bg-[#d6d5d5] border border-solid rounded border-[#4F4F4F] px-1 h-6">
                        {{ $t("header.search") }}
                    </button>
                </div>
                <p v-if="isInvalidId" class="text-red-500">IDは存在していません。</p>
            </div>
            <div class="cursor-pointer hover:bg-gray-300 p-1 rounded-md min-w-fit mr-2" @click="handleLogout">
                {{ $t("header.logout") }}
            </div>
        </div>
    </div>
</template>

<script>
import { logout } from "@/api";
import { removeToken } from "@/utils/authToken";
import { TYPE_USER } from "@/const";
import Logo from "@/components/Elements/Logo.vue";
import { reactive, computed, ref, watch, inject } from "vue";
import { useRouter } from "vue-router";
import { useStore } from "vuex";
import { getReservationByCondition, getListAllSpaces } from "@/api";
import { MODULE_STORE, STATUS_SPACE, ROUTER_PATH, STEP_CREATE_SPACE_FROM_API } from "@/const";

export default {
    name: "Header",
    components: { Logo },
    props: {
        isShowHeader: {
            type: Boolean,
            default: true,
        },
    },
    methods: {
        async handleLogout() {
            try {
                await logout();
                removeToken(TYPE_USER.ADMIN);
                window.location.reload();
            } catch (error) {
                console.log("error: ", error);
            }
        },
    },
    setup() {
        const store = useStore();
        const router = useRouter();
        const spaceId = ref("");
        const reservationId = ref("");
        const spaceList = ref([]);
        const reservationList = ref([]);
        const isInvalidId = ref(false);

        // watch(spaceId, (val) => (isInvalidId.value = false));
        // watch(reservationId, (val) => (isInvalidId.value = false));

        watch([spaceId, reservationId], ([newSpaceId, newReservationId]) => {
            isInvalidId.value = false
        })

        const handleFetchSpaceList = async (page = 1) => {
            const { data, pagination } = await getListAllSpaces(page);
            spaceList.value.push(...data);
            if (pagination.current_page < pagination.total) {
                await handleFetchSpaceList(page + 1);
            }
        };
        const handlePushToSpace = (item) => {
            const { status } = item;
            const step = item["draft-step"];
            if (status == STATUS_SPACE.PUBLIC || status == STATUS_SPACE.ARCHIVED) {
                store.commit(
                    `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_ID_EDIT_SPACE}`,
                    item.id
                );
                router.push({ name: "edit-published-space", params: { id: item.id } });
                return;
            }
            router.push({ name: STEP_CREATE_SPACE_FROM_API[step], query: { id: item.id } });
        };

        const handleSpaceId = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await handleFetchSpaceList();
                const targetSpaceIdx = spaceList.value.findIndex((space) => space.id == spaceId.value);
                if (targetSpaceIdx == -1) {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                    isInvalidId.value = true;
                    return;
                }
                const targetSpace = spaceList.value[targetSpaceIdx];
                handlePushToSpace(targetSpace);
                spaceId.value = "";
            } catch (error) {
                console.error("error: ", error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        const handleReservationId = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                if (reservationList.value.length == 0) {
                    const { data } = await getReservationByCondition();
                    reservationList.value = data.data;
                }
                const targetIdx = reservationList.value.findIndex((item) => item.id == reservationId.value);
                if (targetIdx == -1) {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                    isInvalidId.value = true;
                    return;
                }
                const targetReservation = reservationList.value[targetIdx];
                router.push({ name: ROUTER_PATH.RESERVATIONS_CONFIRMATION, query: { idReservation: targetReservation.id } });
                reservationId.value = "";
            } catch (error) {
                console.error("error: ", error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        return { spaceId, reservationId, handleSpaceId, isInvalidId, handleReservationId };
    },
};
</script>
