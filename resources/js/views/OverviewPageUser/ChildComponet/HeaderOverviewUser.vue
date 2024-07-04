<template>
    <div class="w-full h-ful">
        <div
            class="w-full h-[50px] bg-[#2877BC] flex items-center justify-center text-lg text-white text-[14px] font-bold">
            {{ $t("overview_page_user.header.title") }}
        </div>
        <div class="w-full h-[100%] bg-[#fff] border border-b-0.5 border-solid border-[#ccc] opacity-95">
            <div class="px-[15px] py-[5px] flex justify-center">
                <div class="w-[14%] h-full">
                    <div class="w-full h-full flex flex-col">
                        <img :src="logoTimeSharing" alt="logoTimeSharing" class="w-4/5 h-4/5 object-contain" />
                        <span class="w-4/5 h-4/5 my-1 text-[10px]">{{ $t("overview_page_user.header.title_logo")
                            }}</span>
                    </div>
                </div>
                <div>
                    <img :src="bestRate" alt="bestRate" class="w-[88px] h-[80px] object-contain" />
                </div>
                <div>
                    <img :src="jpxPrimeTokyo" alt="jpxPrimeTokyo" class="w-[88px] h-[80px] object-contain" />
                </div>
                <div class="flex">
                    <div class="w-full h-full flex items-center mx-[12px]">
                        <ul v-for="item in itemSearch" :key="item.id">
                            <li
                                class="border-b-2 border-dotted border-[#747474] text-[14px] mx-[12px] whitespace-nowrap py-[10px]">
                                {{ item.area }}
                            </li>
                        </ul>
                    </div>
                    <div class="w-full h-full flex items-center">
                        <router-link :to="linkRoute.loginLink">
                            <ButtonUser class="my-[15px] mr-[10px]"
                                :text="$t(`overview_page_user.header.text_button.button1`)" bg="bg-[#297fca]"
                                icon="fa fa-arrow-right" />
                        </router-link>
                        <router-link :to="linkRoute.registerLink">
                            <ButtonUser class="my-[15px] mr-[10px]"
                                :text="$t(`overview_page_user.header.text_button.button2`)" bg="bg-[#297fca]"
                                icon="fa fa-user-plus" />
                        </router-link>
                        <ButtonUser class="my-[15px] mr-[10px]"
                            :text="$t(`overview_page_user.header.text_button.button3`)" bg=" bg-[#ff8a0d]" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import logoTimeSharing from "@/assets/images/time_sharing_logo.png";
import bestRate from "@/assets/images/overviewPageUser/bestrateicon_header.svg";
import jpxPrimeTokyo from "@/assets/images/overviewPageUser/jpx_prime_tokyo.svg";
import ButtonUser from "@/views/OverviewPageUser/ChildComponet/ButtonUser.vue";
export default {
    name: "HeaderOverviewUser",
    components: {
        ButtonUser,
    },
    setup() {
        const itemSearch = [
            {
                id: 1,
                area: "エリアから探す",
            },
            {
                id: 2,
                area: "利用用途から探す",
            },
            {
                id: 3,
                area: "使い方ガイド",
            },
        ];
        const linkRoute = {
            loginLink: `${ROUTER_PATH.LOGIN_CUSTOMER}`,
            registerLink: `${ROUTER_PATH.REGISTER_CUSTOMER}`,
        };
        return {
            logoTimeSharing,
            bestRate,
            jpxPrimeTokyo,
            itemSearch,
            linkRoute,
        };
    },
};
</script>

<style scoped></style>
