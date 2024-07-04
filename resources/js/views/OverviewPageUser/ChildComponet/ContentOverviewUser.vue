<template>
    <div class="max-w-[1120px] h-full items-center mx-auto">
        <div
            class=" w-full h-full text-[25px] font-bold my-[24px] py-[20px] border-b-[1px] border-[#ddd] border-dotted text-left break-al">
            {{ $t("overview_page_user.content.title") }}
        </div>
        <div class="">
            <div class="flex flex-wrap gap-[2%] items-stretch">
                <div class="w-[32%] mb-5 bg-[#efefef] p-4 hover:opacity-50 cursor-pointer" v-for="item in itemContents"
                    :key="item.id">
                    <img class="bg-cover rounded" :src="item.img" alt="" />
                    <div class="w-full py-[8px] text-left text-[22px] truncate break-all">
                        {{ item.id }}
                        <router-link :to="`${ROUTER_PATH.HOME}${item.id}/${ROUTER_PATH.SPACE_DETAILS_CLIENT}`">
                            {{ item.itemTitle }}
                        </router-link>
                    </div>
                    <div class="flex justify-start py-10px]">
                        <div class="h-full bg-[#cfd8dc] leading-6 mr-[16px] px-[10px] rounded">{{ item.people }}</div>
                        <div class="h-full bg-[#cfd8dc] leading-6 mr-[16px] px-[10px] rounded">{{ item.price }}</div>
                    </div>
                    <div
                        class=" w-full pb-auto font-normal text-[14px]  py-[10px] text-left mb-[10px] break-all whitespace-pre-line leading-7">
                        {{ item.content }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import itemContent1 from "@/assets/images/overviewPageUser/itemContent1.webp";
import itemContent2 from "@/assets/images/overviewPageUser/itemContent2.webp";
import itemContent3 from "@/assets/images/overviewPageUser/itemContent3.webp";
import itemContent4 from "@/assets/images/overviewPageUser/itemContent4.webp";
import itemContent5 from "@/assets/images/overviewPageUser/itemContent5.webp";
import itemContent6 from "@/assets/images/overviewPageUser/itemContent6.webp";

import { ROUTER_PATH } from "@/const";

export default {
    name: "ContentOverviewUser",
    setup() {
        const itemContents = [
            {
                id: 1,
                img: itemContent1,
                itemTitle: " TIME SHARING 渋谷宮益坂2C（タイムシェアリング） ",
                people: "~ 30 人",
                price: "¥5,940円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
            {
                id: 2,
                img: itemContent2,
                itemTitle: "  Glade Park（グレイドパーク）  ",
                people: "~ 120 人",
                price: "¥18,840円～",
                content: `丸ノ内線西新宿駅「２番出口」より徒歩2分                        
           東京都新宿区西新宿6-6-2 新宿国際ビルディング 地下1階`,
            },
            {
                id: 3,
                img: itemContent3,
                itemTitle: "  QUARTZ GALLERY 9F（クオーツギャラリー）  ",
                people: "~ 30 人",
                price: "¥5,940円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
            {
                id: 4,
                img: itemContent4,
                itemTitle: " TIME SHARING 渋谷宮益坂2C（タイムシェアリング） ",
                people: "~ 150 人",
                price: "¥20,850円～",
                content: `丸ノ内線西新宿駅「２番出口」より徒歩2分                        
           東京都新宿区西新宿6-6-2 新宿国際ビルディング 地下1階`,
            },
            {
                id: 5,
                img: itemContent5,
                itemTitle: "  QUARTZ GALLERY 9F（クオーツギャラリー） ",
                people: "~ 20 人",
                price: "¥10,040円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
            {
                id: 6,
                img: itemContent6,
                itemTitle: " TIME SHARING 渋谷宮益坂2C（タイムシェアリング） ",
                people: "~ 30 人",
                price: "¥5,940円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
            {
                id: 7,
                img: itemContent4,
                itemTitle: "  Glade Park（グレイドパーク）  ",
                people: "~ 120 人",
                price: "¥18,840円～",
                content: `丸ノ内線西新宿駅「２番出口」より徒歩2分                        
           東京都新宿区西新宿6-6-2 新宿国際ビルディング 地下1階`,
            },
            {
                id: 8,
                img: itemContent5,
                itemTitle: "  QUARTZ GALLERY 9F（クオーツギャラリー） ",
                people: "~ 20 人",
                price: "¥10,040円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
            {
                id: 9,
                img: itemContent6,
                itemTitle: "  QUARTZ GALLERY 9F（クオーツギャラリー） ",
                people: "~ 20 人",
                price: "¥10,040円～",
                content: `JR山手線渋谷駅「宮益坂口」より徒歩4分            
           東京都渋谷区渋谷1-8-3 TOC第1ビル2階`,
            },
        ];
        return { itemContents, itemContent1, itemContent2, itemContent3, itemContent4, itemContent5, itemContent6, ROUTER_PATH };
    },
};
</script>


<style scoped></style>
