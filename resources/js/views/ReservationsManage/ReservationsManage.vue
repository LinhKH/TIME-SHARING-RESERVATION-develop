<template>
    <div class="p-3">
        <div class="flex justify-between">
            <ButtonFilter @clickBtn="handleShowFilter" />
            <ButtonDownloadCSV @onExportFile="handleExportCsv" />
        </div>

        <FilterReservation v-if="isShowFilter" class="p-3 mt-2" :optionStatusReservation="optionStatusReservation"
            :optionPurposeOfUse="optionPurposeOfUse" :optionReservationType="optionReservationType"
            @filter="(data) => handleFilter(data)" :dataFilter="dataFilter" />

        <div class="flex my-2">
            <ButtonCommon :text="$t('reservation_confirmation.confirm_all_reservations')" :style="`py-1 px-2 mr-2`"
                @click="getReservationByConditionFromApi(null)" />
            <ButtonCommon :text="$t('reservation_confirmation.see_only_bookings')"
                :style="`px-2 py-1 mr-2 bg-[#f48fb3] text-white`"
                @click="getReservationByConditionFromApi(statusPendingReservation)" />
            <ButtonCommon :text="$t('reservation_confirmation.only_reservations')" :style="`px-2 py-1`"
                @click="getReservationByConditionFromApi(statusCancellationReservation)" />
        </div>

        <div class="table-container">
            <ReservationsManageTable :dataTable="dataTableExample" />
        </div>

        <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total"
            @onBack="handleNextPage" @onNext="handleNextPage" />
    </div>
</template>

<script>
import Datepicker from "vue3-datepicker";
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import ButtonCommon from "@/components/Buttons/ButtonCommon";
import ButtonDownloadCSV from "@/components/Buttons/ButtonDownloadCSV";
import Label from "@/components/Label";
import Input from "@/components/Form/Input.vue";
import { inject, reactive, ref, watch } from "vue";
import Select from "@/components/Form/Select.vue";
import { useI18n } from "vue-i18n";
import ReservationsManageTable from "@/components/ReservationsManage/ReservationsManageTable.vue";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import { useRoute, useRouter } from "vue-router";
import {
    getOptionReservationType,
    getOptionPurposeOfUse,
    getOptionStatusReservation,
    getReservationByCondition,
    getListAsCsv,
} from "@/api";
import { useStore } from "vuex";
import FilterReservation from "./FilterReservation.vue";
import Pagination from "@/components/Pagination";
import moment from "moment";

export default {
    name: "ReservationsManage",
    components: {
        ButtonFilter,
        ButtonCommon,
        ButtonDownloadCSV,
        Label,
        Input,
        Select,
        Datepicker,
        ReservationsManageTable,
        FilterReservation,
        Pagination,
    },
    setup() {
        const { t } = useI18n();
        const route = useRoute();
        const router = useRouter();
        const store = useStore();
        const toast = inject("$toast");
        const isShowFilter = ref(false);
        const optionStatusReservation = ref();
        const optionPurposeOfUse = ref();
        const optionReservationType = ref();
        const dataFilter = ref();
        const pagination = ref(null);

        let statusPendingReservation = reactive({
            status: ["pending-approval-from-owner"],
        });

        let statusCancellationReservation = reactive({
            status: ["reservation-request-canceled"],
        });

        const statusCurrent = ref(null);

        let dataTableExample = reactive({
            header: [
                {
                    text: "予約ID",
                },
                {
                    text: "ユーザー",
                    width: "12%",
                },
                {
                    text: "	利用スペース",
                    width: "15%",
                },
                {
                    text: "用途",
                    width: "10%",
                },
                {
                    text: "	ご利用日",
                    width: "10%",
                },
                {
                    text: "ステータス",
                    width: "10%",
                },
                {
                    text: "予約完了日時",
                    width: "10%",
                },
                {
                    text: "クーポン利用",
                },
                {
                    text: "外部経由",
                },
                {
                    text: "",
                },
            ],

            data: [],
        });
        const mapData = (data) => {
            if (data && data.length) {
                const dataConvert = data.map((item) => {
                    const nameJa =
                        item.rental_space?.rental_space_eav?.find((item) => item.attribute == "generalBasicSpaceNameJa")?.value ||
                        "";
                    // const nameKana = item.rental_space?.rental_space_eav?.find(
                    //   (item) => item.attribute == "generalBasicSpaceNameKana"
                    // ).value;
                    const spaceName = nameJa;
                    return [
                        {
                            text: item.id,
                            type: "links",
                            url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${item.id}`,
                        },
                        {
                            text: item?.user
                                ? item?.user?.last_name + item?.user?.first_name + `(${item.people_count})`
                                : item?.customer?.last_name + item?.customer?.first_name + `(${item.people_count})`,
                            type: "links",
                            url: item?.user
                                ? `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CUSTOMER_VIEW}/${item.user.id}?byUser=true`
                                : `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CUSTOMER_VIEW}/${item.customer.id}?byCustomer=true`,
                        },
                        {
                            text: spaceName,
                            type: "links",
                            url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.EDIT}/${item.rental_space.id}`,
                        },
                        {
                            text: item.use_purpose_category,
                            type: "text",
                        },
                        {
                            text:
                                moment(String(item.creation_time)).format("YYYY年MM月DD日[\n]") +
                                item.planless_start_time +
                                "~" +
                                item.planless_end_time,

                            type: "text",
                        },
                        {
                            text: handleFilterStatus(item.status),
                            type: "text",
                        },
                        {
                            text: moment(item.created_at).format("YYYY年MM月DD日[\n]hh:mm"),
                            type: "links",
                            url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${item.id}`,
                        },
                        {
                            text: item.coupon_name ?? "なし",
                            type: "text",
                        },
                        {
                            //   label: "Via external fake",
                            type: "text",
                        },
                        {
                            id: item.id,
                            type: "button_detail",
                        },
                    ];
                });
                dataTableExample.data = dataConvert;
            } else {
                dataTableExample.data = [];
            }
        };
        const initData = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await Promise.all([getOptionReservationType(), getOptionPurposeOfUse(), getOptionStatusReservation()]).then(
                    (data) => {
                        optionReservationType.value = data[0];
                        optionPurposeOfUse.value = data[1];
                        optionStatusReservation.value = data[2];
                    }
                );
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        initData();

        const handleShowFilter = () => (isShowFilter.value = !isShowFilter.value);

        const handleFilter = async (data) => {
            const cloneObj = { ...data };
            if (cloneObj.hasOwnProperty("people_count")) {
                delete cloneObj.people_count;
            }
            router.push({
                path: route.path,
                query: {
                    ...cloneObj,
                },
            });
        };

        const getReservationByConditionFromApi = async (params) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

                const { data } = await getReservationByCondition(params);

                statusCurrent.value = params;
                pagination.value = {
                    total: data?.last_page,
                    current_page: data?.current_page,
                    perPage: data?.per_page,
                };

                return mapData(data.data);
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        watch(
            () => route.query,
            (value) => {
                if (Object.keys(value).length) {
                    dataFilter.value = { ...value };
                } else {
                    dataFilter.value = {};
                }
                getReservationByConditionFromApi(value);
            },
            { immediate: true, deep: true }
        );

        const handleBackPage = (page) => {
            const params = {
                page: page,
                status: statusCurrent?.value?.status,
            };
            return getReservationByConditionFromApi(params);
        };

        const handleNextPage = (page) => {
            const params = {
                page: page,
                status: statusCurrent?.value?.status,
            };
            return getReservationByConditionFromApi(params);
        };

        const handleExportCsv = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getListAsCsv();
                const blob = new Blob([res], { type: "text/csv;" });
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement("a");
                a.setAttribute("href", url);
                a.setAttribute("download", "list_reservation.csv");
                a.click();
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };

        const handleFilterStatus = (value) => {
            switch (value) {
                case "pending-approval-from-owner":
                    return "オーナーからの承認待ち";

                case "reservation-by-proxy: Waiting for supervisor-approval":
                    return "代理予約：上長承認待ち";

                case "reject-due-to-timeout":
                    return "時間切れによる否認";

                case "reservation-request-canceled":
                    return "予約リクエスト取消済";

                case "waiting-for-card-information-input":
                    return "カード情報入力待ち";

                case "completed-cash-payment":
                    return "現金払い完了";

                default:
                    break;
            }
        };

        return {
            isShowFilter,
            dataTableExample,
            handleShowFilter,
            optionStatusReservation,
            optionPurposeOfUse,
            optionReservationType,
            handleFilter,
            dataFilter,
            handleExportCsv,
            statusPendingReservation,
            statusCancellationReservation,
            getReservationByConditionFromApi,
            pagination,
            handleBackPage,
            handleNextPage,
            statusCurrent,
            handleFilterStatus,
        };
    },
};
</script>

<style class="scss" scoped>
li.siderbar__item.active {
    margin-bottom: -1px;
}
</style>
