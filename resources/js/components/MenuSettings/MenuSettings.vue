<template>
    <div class="p-2">
        <div
            class="flex flex-wrap w-full pt-2 px-3 rounded border border-solid border-[#e3e3e3] shadow-inner bg-[#f5f5f5] mb-5">
            <router-link active-class="bg-[#337ab7]" :to="item.url" v-for="(item, index) in listMenus" :key="index"
                :class="{ activeChild: hasChildActive(item.name) }"
                class="p-2 border border-solid border-[#ccc] bg-white rounded mb-2 mr-2 item_menu">
                <i class="mr-1 item_icon text-[#337ab7]" :class="item.icon"></i>
                <span class="item_text text-[#337ab7]">{{ item.text }}</span>
            </router-link>
        </div>
        <router-view></router-view>
    </div>
</template>

<script>
import { ROUTER_PATH, NESTED_ROUTE, ROUTE_NAME } from "@/const";
import { useRouter, useRoute } from "vue-router";
export default {
    name: "MenuSettings",
    setup() {
        const router = useRouter();
        const route = useRoute();
        if (route.path === `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}`) {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.SYSTEM_CONFIG}`);
        }
        const listMenus = [
            {
                icon: "fa fa-wrench",
                text: "システム設定",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.SYSTEM_CONFIG}`,
            },
            {
                icon: "fa fa-newspaper-o",
                text: "お知らせ",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.NEWS}`,
                name: ROUTE_NAME.ADMIN.NEWS,
            },
            {
                icon: "fa fa-newspaper-o",
                text: "オーナー向けお知らせ",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.CUSTOMER_NEWS}`,
            },
            {
                icon: "fa fa-question-circle",
                text: "よくある質問",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.FAQ}`,
            },
            {
                icon: "fa fa-pencil",
                text: "ページ",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE}`,
                name: ROUTE_NAME.ADMIN.STATIC_PAGE,
            },
            {
                icon: "fa fa-code",
                text: "HTMLページ",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.HTML_PAGE}`,
            },
            {
                icon: "fa fa-plus-square",
                text: "まとめ",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COMPILATION}`,
                name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COMPILATION,
            },
            {
                icon: "fa fa-picture-o",
                text: "シーン",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.SLIDE}`,
            },
            {
                icon: "fa fa-google",
                text: "メタ情報",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.META}`,
            },
            {
                icon: "fa fa-plus-square",
                text: "利用目的",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_USE_PURPOSE}`,
                name: ROUTE_NAME.ADMIN.RENTAL_SPACE_USE_PURPOSE,
            },
            {
                icon: "fa fa-plus-square",
                text: "設備情報",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_EQUIPMENT_INFORMATION}`,
                name: ROUTE_NAME.ADMIN.RENTAL_SPACE_EQUIPMENT_INFORMATION,
            },
            {
                icon: "fa fa-street-view",
                text: "大エリア",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA}`,
                name: ROUTE_NAME.ADMIN.AREA,
            },
            {
                icon: "fa fa-street-view",
                text: "中・小エリア",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.AREA_GROUP}`,
                name: ROUTE_NAME.ADMIN.AREA_GROUP,
            },
            {
                icon: "fa fa-envelope-o",
                text: "メールテンプレート",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.EMAIL_TEMPLATE}`,
                name: ROUTE_NAME.ADMIN.EMAIL_TEMPLATE,
            },
            {
                icon: "fa fa-plus-square",
                text: "ポイント",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_POINTS}`,
            },
            {
                icon: "fa fa-plus-square",
                text: "オーナー登録申し込み",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORGANIZATION}/${ROUTER_PATH.REQUEST_MANAGEMENT}`,
            },
            {
                icon: "fa fa-book",
                text: "ドキュメント",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.DOCUMENTATION}`,
            },
            {
                icon: "fa fa-link",
                text: "フッターリンク",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.FOOTER_LINKS}`,
                name: ROUTE_NAME.ADMIN.FOOTER_LINKS,

            },
            {
                icon: "fa fa-sun-o",
                text: "祝日",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.HOLIDAY_INFO}`,
                name: ROUTE_NAME.ADMIN.HOLIDAY_INFO,

            },
            {
                icon: "fa fa-university",
                text: "お支払い",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.PAYOUT}`,
            },
            {
                icon: "fa fa-percent",
                text: "ク ー ポ ン",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.RENTAL_SPACE_COUPONS}`,
                name: ROUTE_NAME.ADMIN.RENTAL_SPACE_COUPONS,
            },
            {
                icon: "fa fa-percent",
                text: "キャンペーン",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.CAMPAIGN}`,
            },
            {
                icon: "fa fa-link",
                text: "グローバルトラッキングリンク",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.TRACKING_LINKS}`,
                name: ROUTE_NAME.ADMIN.TRACKING_LINKS,
            },
            {
                icon: "fa fa-file-archive-o",
                text: "XML出力",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.XML_EXPORT}`,
            },
            {
                icon: "fa fa-file-text-o",
                text: "CSV出力",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.CSV_EXPORT}`,
                name: ROUTE_NAME.ADMIN.CSV_EXPORT,

            },
            {
                icon: "fa fa-file-text-o",
                text: "送客業者",
                url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.FIRST_CONTRACTOR}`,
            },
        ];
        const hasChildActive = (name) => {
            const currentRoute = route.name;
            if (NESTED_ROUTE[name]) return NESTED_ROUTE[name].includes(currentRoute);
        };
        return { listMenus, hasChildActive };
    },
};
</script>
<style scoped>
.item_menu.router-link-exact-active .item_icon,
.item_menu.router-link-exact-active .item_text {
    color: white;
}

.activeChild {
    background: #337ab7;

    /* color: white !important; */
}

.activeChild i,
.activeChild span {
    color: white !important;
}
</style>
