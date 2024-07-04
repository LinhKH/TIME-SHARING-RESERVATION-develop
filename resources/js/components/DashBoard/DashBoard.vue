<template>
    <div class="p-[10px] font-serif">
        <MenuForm :listMenus="listMenus" />
    </div>
</template>

<script>
import MenuForm from "@/components/MenuForm";
import { ROUTER_PATH } from "@/const";
import { useRoute, useRouter } from "vue-router";
export default {
    name: "DashBoard",
    components: {
        MenuForm,
    },
    setup() {
        const route = useRoute();
        const router = useRouter();
        if (route.path === `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}`) {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.DASHBOARD}`)
        }
        const listMenus = [
            {
                id: 1,
                active: true,
                icon: "fa fa-dashboard i_br",
                text: "システム設定",
                link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.DASHBOARD}`,
            },
            {
                id: 2,
                active: false,
                icon: "fa fa-list i_br",
                text: "お知らせ",
                link: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_MANAGE}`,
            },
            {
                id: 3,
                active: false,
                icon: "fa fa-calendar i_br",
                text: "オーナー向けお知らせ",
                link: `/admin/reservations/calendar`,
            },
            {
                id: 4,
                active: false,
                icon: "fa fa-jpy i_br",
                text: "よくある質問",
                link: `/admin/reservations/billing-download`,
            },
        ];
        return {
            listMenus,
        };
    },
};
</script>

<style></style>
