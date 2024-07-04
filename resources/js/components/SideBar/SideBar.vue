<template>
    <div class="bg-[rgba(0,0,0,.02)]">
        <div class="flex justify-center items-center h-10">
            <div class="mr-2 flex items-center">
                <i class="fa fa-lg fa-user"></i>
            </div>
            <span @click="handleUpdateProfile" class="font-bold hover:cursor-pointer hover:underline"> {{ nameUser
                }}</span>
        </div>
        <ul>
            <li v-for="(item, index) in list" :key="index"
                class="flex items-center hover:bg-[#dbdbdb] py-[6px] rounded px-2 cursor-pointer"
                :class="{ 'router-link-active': item.link == routerPath }">
                <div v-if="item.id == CALENDAR_ID">
                    <div class="item-list flex items-center" @click="handleToggleSubmenu">
                        <div class="mr-1 flex items-center">
                            <i class="" :class="item.icon"></i>
                        </div>
                        <span class="">{{ item.title }}</span>
                    </div>
                    <ListMenuSpace v-if="isShowSubmenu" :listSpace="spacePublished" />
                </div>
                <div v-else class="item-list flex items-center" @click="handlePush(item.link)">
                    <div class="mr-1 flex items-center">
                        <i class="" :class="item.icon"></i>
                    </div>
                    <span class="">{{ item.title }}</span>
                </div>
            </li>
        </ul>
    </div>
</template>
<script>
import { ROUTER_PATH, MODULE_STORE, ROUTE_NAME } from "@/const";
import { useStore } from "vuex";
import { ref, inject, computed } from "vue";
import { useRouter, useRoute } from "vue-router";
import { getUserProfileApi, getListAllSpaces } from "@/api";
import ListMenuSpace from "./ListMenuSpace.vue";

export default {
    name: "SideBar",
    components: { ListMenuSpace },

    data() {
        return {
            list: [
                {
                    id: 1,
                    title: this.$t("side_bar_components.dashboard"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.DASHBOARD}`,
                    icon: "fa fa-clock-o",
                },
                {
                    id: 2,
                    title: this.$t("side_bar_components.reservation_list"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_MANAGE}`,
                    icon: "fa fa-bars",
                },
                {
                    id: 3,
                    title: this.$t("side_bar_components.external_reservation"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.EXTERNAL_RESERVATION}`,
                    icon: "fa fa-building-o i_br",
                },
                {
                    id: 4,
                    title: this.$t("side_bar_components.tour_management"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}/tour-list`,
                    icon: "fa fa-lg fa-star",
                },
                {
                    id: 5,
                    title: this.$t("side_bar_components.reservation_calendar"),
                    link: "/home",
                    icon: "fa fa-lg fa-calendar",
                },
                {
                    id: 7,
                    title: this.$t("side_bar_components.google_calendar_sync"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.GOOGLE_CALENDAR}`,
                    icon: "fa fa-lg fa-calendar-plus-o",
                },
                {
                    id: 8,
                    title: this.$t("side_bar_components.inquiries_to_the_space"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.INQUIRIES}`,
                    icon: "fa fa-lg fa-comment",
                },
                {
                    id: 9,
                    title: this.$t("side_bar_components.space_list"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}`,
                    icon: "fa fa-lg fa-home",
                },
                {
                    id: 10,
                    title: this.$t("side_bar_components.user"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.LIST_CUSTOMER}`,
                    icon: "fa fa-lg fa-user",
                },
                {
                    id: 13,
                    title: this.$t("side_bar_components.responsible_person"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.USER_MANAGER}`,
                    icon: "fa fa-lg fa-user",
                },
                {
                    id: 14,
                    title: this.$t("side_bar_components.company_organization"),
                    link: `/test`,
                    icon: "fa fa-lg fa-star",
                },
                {
                    id: 15,
                    title: this.$t("side_bar_components.withdrawal"),
                    link: "/home",
                    icon: "fa fa-lg fa-inbox",
                },
                {
                    id: 16,
                    title: this.$t("side_bar_components.manage_settings"),
                    link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}`,
                    icon: "fa fa-lg fa-cogs",
                },
            ],
            CALENDAR_ID: 7,
        };
    },
    setup() {
        const store = useStore();
        const router = useRouter();
        const route = useRoute();
        const toast = inject("$toast");
        const nameUser = ref();
        const spaceList = ref([]);
        const isShowSubmenu = ref(false);
        const routerPath = computed(() => route.path);

        const spacePublished = computed(() => {
            return spaceList.value.filter((item) => item.status != "pending");
        });

        const handleFetchSpaceList = async (page = 1) => {
            const { data, pagination } = await getListAllSpaces(page);
            spaceList.value.push(...data);
            if (pagination.current_page < pagination.total) {
                await handleFetchSpaceList(page + 1);
            }
        };
        const getInformationUser = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getUserProfileApi();
                nameUser.value = `${res?.first_name} ${res?.last_name}`;
            } catch (errors) {
                const error = errors.message || "has error";
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const getListSpaces = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await handleFetchSpaceList();
            } catch (errors) {
                console.error(errors);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const handlePush = (path) => router.push(path);
        const handleToggleSubmenu = async () => {
            if (spaceList.value.length == 0) {
                await getListSpaces();
            }
            isShowSubmenu.value = !isShowSubmenu.value;
        };

        const handleUpdateProfile = () => {
            router.push({ name: ROUTE_NAME.ADMIN.ADMIN_UPDATE_INFO })
        }

        getInformationUser();
        return {
            nameUser,
            handlePush,
            routerPath,
            spacePublished,
            handleToggleSubmenu,
            isShowSubmenu,
            handleUpdateProfile,
        };
    },
};
</script>
<style scoped>
.router-link-active {
    background-color: #dbdbdb;
}
</style>
