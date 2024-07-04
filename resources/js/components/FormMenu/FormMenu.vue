<template>
    <div class="font-serif">
        <div
            class="flex justify-between items-center py-[20px] border-t border-t-solid border-t-[#ccc] first:border-none">
            <button
                class="border border-solid rounded-3xl hover:bg-[#eee] py-[5px] px-[14px] text-[12px] text-[#337ab7]">
                ← 2022/08
            </button>
            <span class="text-[18px]">{{ $t("dashboard.reservations_and_sales") }}</span>
            <button
                class="border border-solid rounded-3xl hover:bg-[#eee] py-[5px] px-[14px] text-[12px] text-[#337ab7]">
                2022/10 →
            </button>
        </div>
        <div class="text-end">
            <span class="text-[12px]">0件中 1 〜 0件</span>
        </div>
        <div>
            <Reservation :dashboardHeaders="dashboardHeaders" :reservationsSales="reservationsSales" />
            <ListBooking :listOfBookingsHeader="listOfBookingsHeader" :listOfBookings="listOfBookings" />
            <SaleMonth :saleThisMonthHeader="saleThisMonthHeader" :subSaleMonthHeader="subSaleMonthHeader"
                :saleThisMonth="saleThisMonth" :total="total" />
        </div>
    </div>
</template>
<script>
import { useI18n } from "vue-i18n";
import NoReservation from "./child/NoReservation.vue";
import Reservation from "./child/Reservation.vue";
import ListBooking from "./child/ListBooking.vue";
import SaleMonth from "./child/SaleMonth.vue";
export default {
    name: "FormMenu",
    components: {
        NoReservation,
        Reservation,
        ListBooking,
        SaleMonth,
        SaleMonth,
    },
    setup() {
        const { t } = useI18n();
        const dashboardHeaders = [
            t("dashboard.online_reservation"),
            t("dashboard.total"),
            t("dashboard.month_use_completed"),
            t("dashboard.expected_month_used"),
            t("dashboard.use_in_month"),
            t("dashboard.use_in_month"),
            t("dashboard.use_in_month"),
            t("dashboard.from"),
            t(""),
        ];
        const reservationsSales = [
            {
                id: 1,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 2,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 3,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 4,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 5,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 6,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 7,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
            {
                id: 8,
                numberReservation: t("dashboard.total_number_reservation"),
                total: 3,
                useCompleted: 2,
                expectedUse: 1,
                useMonth1: 0,
                useMonth2: 0,
                useMonth3: 0,
                from: 0,
            },
        ];
        const listOfBookingsHeader = [
            t("dashboard.reservation_id"),
            t("dashboard.user"),
            t("dashboard.space_used"),
            t("dashboard.usage"),
            t("dashboard.date_of_use"),
            t("dashboard.status"),
            t("dashboard.reservation_completion"),
            t("dashboard.use_coupon"),
            t("dashboard.via_external"),
        ];
        const listOfBookings = [
            {
                id: 4114290,
                user: "三好 佑介(44名)",
                spaceUsed: "TIME SHARING 渋谷ワールド宇田川ビル 9F",
                usage: "イベント",
                dateOfUse: {
                    date: "2020年10月29日",
                    day: "(木)",
                    time: "18:00 〜 22:00",
                    descript: "仮予約　待ちな",
                },
                status: {
                    icon: "fa fa-university",
                    pendingApproval: "オーナーからの承認待ち",
                    requestReservation: "(リクエスト予約)",
                },
                reservationCompletion: {
                    date: "2020年10月28日",
                    time: "11:15",
                },
                useCoupon: "なし",
                viaExternal: "",
            },
            {
                id: 4114290,
                user: "三好 佑介(44名)",
                spaceUsed: "TIME SHARING 渋谷ワールド宇田川ビル 9F",
                usage: "イベント",
                dateOfUse: {
                    date: "2020年10月29日",
                    day: "(木)",
                    time: "18:00 〜 22:00",
                    descript: "仮予約　待ちな",
                },
                status: {
                    icon: "fa fa-university",
                    pendingApproval: "オーナーからの承認待ち",
                    requestReservation: "(リクエスト予約)",
                },
                reservationCompletion: {
                    date: "2020年10月28日",
                    time: "11:15",
                },
                useCoupon: "なし",
                viaExternal: "",
            },
            {
                id: 4114290,
                user: "三好 佑介(44名)",
                spaceUsed: "TIME SHARING 渋谷ワールド宇田川ビル 9F",
                usage: "イベント",
                dateOfUse: {
                    date: "2020年10月29日",
                    day: "(木)",
                    time: "18:00 〜 22:00",
                    descript: "仮予約　待ちな",
                },
                status: {
                    icon: "fa fa-university",
                    pendingApproval: "オーナーからの承認待ち",
                    requestReservation: "(リクエスト予約)",
                },
                reservationCompletion: {
                    date: "2020年10月28日",
                    time: "11:15",
                },
                useCoupon: "なし",
                viaExternal: "",
            },
            {
                id: 4114290,
                user: "三好 佑介(44名)",
                spaceUsed: "TIME SHARING 渋谷ワールド宇田川ビル 9F",
                usage: "イベント",
                dateOfUse: {
                    date: "2020年10月29日",
                    day: "(木)",
                    time: "18:00 〜 22:00",
                    descript: "仮予約　待ちな",
                },
                status: {
                    icon: "fa fa-pause-circle-o",
                    pendingApproval: "オーナーからの承認待ち",
                    requestReservation: "(リクエスト予約)",
                },
                reservationCompletion: {
                    date: "2020年10月28日",
                    time: "11:15",
                },
                useCoupon: "なし",
                viaExternal: "",
            },
            {
                id: 4114290,
                user: "三好 佑介(44名)",
                spaceUsed: "TIME SHARING 渋谷ワールド宇田川ビル 9F",
                usage: "イベント",
                dateOfUse: {
                    date: "2020年10月29日",
                    day: "(木)",
                    time: "18:00 〜 22:00",
                    descript: "仮予約　待ちな",
                },
                status: {
                    icon: "fa fa-university",
                    pendingApproval: "オーナーからの承認待ち",
                    requestReservation: "(リクエスト予約)",
                },
                reservationCompletion: {
                    date: "2020年10月28日",
                    time: "11:15",
                },
                useCoupon: "なし",
                viaExternal: "",
            },
        ];
        const saleThisMonthHeader = [
            {
                title: t("dashboard.space_name"),
                icon: "",
            },
            {
                title: t("dashboard.expected_income"),
                icon: "fa fa-question-circle",
            },
            {},
            {
                title: t("dashboard.fixed_income"),
                icon: "fa fa-question-circle",
            },
            {},
            {
                title: t("dashboard.total"),
                icon: "fa fa-question-circle",
            },
            {},
        ];
        const subSaleMonthHeader = [
            t("dashboard.space_name"),
            t("dashboard.without_tax"),
            t("dashboard.tax_included"),
            t("dashboard.without_tax"),
            t("dashboard.tax_included"),
            t("dashboard.without_tax"),
            t("dashboard.tax_included"),
        ];
        const saleThisMonth = [
            {
                id: 1,
                spaceName: "みんなのテスト",
                withoutTax1: {
                    value: 3.423,
                    error: true,
                },
                taxIncluded1: {
                    value: 5.567,
                    error: false,
                },
                withoutTax2: {
                    value: 3.246,
                    error: false,
                },
                taxIncluded2: {
                    value: 1.236,
                    error: false,
                },
                withoutTax3: {
                    value: 5.694,
                    error: true,
                },
                taxIncluded3: {
                    value: 4.353,
                    error: false,
                },
            },
            {
                id: 2,
                spaceName: "TIME SHARING Biz 渋谷宮益坂2A（タイムシェアリング ビス）【旧みんなの会議室",
                withoutTax1: {
                    value: 5.445,
                    error: true,
                },
                taxIncluded1: {
                    value: 6.15,
                    error: true,
                },
                withoutTax2: {
                    value: 4.554,
                    error: false,
                },
                taxIncluded2: {
                    value: 7.14,
                    error: false,
                },
                withoutTax3: {
                    value: 3.234,
                    error: true,
                },
                taxIncluded3: {
                    value: 4.399,
                    error: true,
                },
            },
            {
                id: 3,
                spaceName: "TIME SHARING Biz 渋谷宮益坂2A（タイムシェアリング ビス）【旧みんなの会議室",
                withoutTax1: {
                    value: 5.445,
                    error: true,
                },
                taxIncluded1: {
                    value: 3.45,
                    error: true,
                },
                withoutTax2: {
                    value: 7.545,
                    error: false,
                },
                taxIncluded2: {
                    value: 4.399,
                    error: false,
                },
                withoutTax3: {
                    value: 5.93,
                    error: true,
                },
                taxIncluded3: {
                    value: 2.342,
                    error: true,
                },
            },
            {
                id: 4,
                spaceName: "TIME SHARING Biz 渋谷宮益坂2A（タイムシェアリング ビス）【旧みんなの会議室",
                withoutTax1: {
                    value: 3431,
                    error: true,
                },
                taxIncluded1: {
                    value: 5.343,
                    error: true,
                },
                withoutTax2: {
                    value: 2.341,
                    error: false,
                },
                taxIncluded2: {
                    value: 8.643,
                    error: false,
                },
                withoutTax3: {
                    value: 3.423,
                    error: true,
                },
                taxIncluded3: {
                    value: 4.593,
                    error: true,
                },
            },
            {
                id: 5,
                spaceName: "TIME SHARING Biz 渋谷宮益坂2A（タイムシェアリング ビス）【旧みんなの会議室",
                withoutTax1: {
                    value: 3431,
                    error: true,
                },
                taxIncluded1: {
                    value: 5.343,
                    error: true,
                },
                withoutTax2: {
                    value: 2.341,
                    error: false,
                },
                taxIncluded2: {
                    value: 8.643,
                    error: false,
                },
                withoutTax3: {
                    value: 3.423,
                    error: true,
                },
                taxIncluded3: {
                    value: 4.593,
                    error: true,
                },
            },
            {
                id: 6,
                spaceName: "TIME SHARING Biz 渋谷宮益坂2A（タイムシェアリング ビス）【旧みんなの会議室",
                withoutTax1: {
                    value: 3431,
                    error: true,
                },
                taxIncluded1: {
                    value: 5.343,
                    error: true,
                },
                withoutTax2: {
                    value: 2.341,
                    error: false,
                },
                taxIncluded2: {
                    value: 8.643,
                    error: false,
                },
                withoutTax3: {
                    value: 3.423,
                    error: true,
                },
                taxIncluded3: {
                    value: 4.593,
                    error: true,
                },
            },
        ];
        const total = [
            {
                withoutTax1: 20.655,
                taxIncluded1: 22.72,
                withoutTax2: 20.655,
                taxIncluded2: 22.72,
                withoutTax3: 20.655,
                taxIncluded3: 22.72,
            },
        ];
        return {
            dashboardHeaders,
            reservationsSales,
            listOfBookingsHeader,
            listOfBookings,
            saleThisMonthHeader,
            subSaleMonthHeader,
            saleThisMonth,
            total,
        };
    },
};
</script>

<style></style>
