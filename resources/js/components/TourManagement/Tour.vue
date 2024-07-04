<template>
    <MenuForm :listMenus="listMenus" />
</template>

<script>
import MenuForm from "@/components/MenuForm";
import { useI18n } from "vue-i18n";
import { ref, onMounted } from "vue";
import { useRouter, useRoute } from "vue-router";
import { ROUTER_PATH, ROUTE_NAME } from "@/const";
export default {
    name: "Tour",
    components: {
        MenuForm,
    },
    setup() {
        const { t } = useI18n();

        const router = useRouter();
        const route = useRoute();
        const listMenus = ref([
            {
                id: 1,
                active: true,
                icon: "",
                text: t("tour_manager.list_visit"),
                routeName: ROUTE_NAME.ADMIN.TOUR_LIST,
            },
            {
                id: 2,
                active: false,
                icon: "",
                text: t("tour_manager.tour_setting"),
                routeName: ROUTE_NAME.ADMIN.TOUR_SETTING,
            },
            {
                id: 3,
                active: false,
                icon: "",
                text: t("tour_manager.tour_guide"),
                routeName: ROUTE_NAME.ADMIN.TOUR_GUIDE,
            },
        ]);

        const showApprovalConfirm = () => { };
        if (route.path === `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}`) {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}/${ROUTER_PATH.TOUR_LIST}`);
        }
        return {
            showApprovalConfirm,
            listMenus,
        };
    },
};
</script>
<style></style>
