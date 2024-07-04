<template>
    <div class="">
        <table class="w-full border-collapse mt-2" v-if="dataTable.data.length != 0">
            <thead>
                <tr class="">
                    <th v-for="(item, index) in headerTable" :key="index"
                        class="border border-solid border-[#ddd] p-[8px] text-left" :class="item.classWidth">
                        {{ item.text }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(tr, index) in dataTable.data" :key="index" class="">
                    <td class="p-2 bg-[#fcf8e3] border border-solid border-[#ddd]" v-for="(td, index) in tr"
                        :key="index">
                        <div class="text-[#337ab7] hover:underline cursor-pointer" v-if="td.type == 'links'"
                            @click="$router.push(td.url)">
                            {{ td.text }}
                        </div>
                        <p v-else-if="td.type == 'text'">
                            <i v-if="td?.text == 'オーナーからの承認待ち'" class="fa fa-university"></i>
                            <i v-if="td?.text == 'カード情報入力待ち'" class="fa fa-money mr-1"></i>
                            <i v-if="td?.text == '現金払い完了'" class="fa fa-check mr-1"></i>
                            <i v-if="td?.text == '予約リクエスト取消済'" class="fa fa-remove mr-1"></i>
                            {{ td.text }}
                        </p>
                        <div class="flex justify-center" v-else-if="td.type == 'button_detail'">
                            <div class="rounded text-center py-2 px-3 bg-white border border-solid border-[#37a200] text-[#37a200] cursor-pointer hover:text-white hover:bg-[#37a200]"
                                @click="() => gotoDetailReservation(td.id)">
                                {{ $t("dashboard.detail") }}
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <h2 v-else>{{ $t("common.no_data") }}</h2>
    </div>
</template>

<script>
import { ref } from "vue";
import { ROUTER_PATH } from "@/const";
import { useRouter } from "vue-router";

export default {
    name: "ReservationsManageTable",
    props: {
        dataTable: { type: Object },
    },
    setup(props) {
        let headerTable = ref([]);
        const router = useRouter();
        headerTable.value = props.dataTable?.header.map((item) => {
            if (item.width) {
                item.classWidth = `w-[${item.width}]`;
            }
            return item;
        });
        const gotoDetailReservation = (id) => {
            router.push(
                `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${id}`
            );
        };
        return { headerTable, gotoDetailReservation };
    },
};
</script>

<style scoped></style>
