<template>
    <div class="w-full h-full p-[15px]">
        <div class="grid grid-cols-6 gap-0">
            <div
                class="col-start-0 col-end-2 border px-[5px] py-[10px] border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.id`) }}
            </div>
            <div class="col-start-2 col-end-7 border px-[5px] py-[10px] border-gray-300 text-[12px]">
                {{ customerView.id }}
            </div>
        </div>
        <div class="flex flex-wrap items-stretch">
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.member_type`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ convertMemberType(customerView.memberType) }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.name`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.name }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.gender`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ convertGender(customerView.gender) }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.date_birthday`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.dateBirthday }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.name_conpany`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.nameConpany }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.name_conpany_Kana`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.nameConpany_Kana }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.telephone_number`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.telephoneNumber }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.email`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.email }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.address`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.address }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.date_register`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.dateRegister }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.status`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                <div v-if="customerView.status == 1" class="flex">
                    <div class="text-[#5cb85c] mr-6 text-center">{{ customerView.statusTrue }}</div>
                    <button @click="changeDisable"
                        class="px-[5px] py-[1px] text-[#d43f3a] border border-red-300 rounded hover:bg-[#d43f3a] hover:text-[#fff]">
                        {{ $t(`customer_view.disable`) }}
                    </button>
                </div>
                <div v-if="!customerView.status" class="flex">
                    <div class="text-[#8a6d3b] mr-6 text-center">{{ customerView.statusFalse }}</div>
                    <button @click="changeDisable"
                        class="px-[5px] py-[1px] border border-gray-300 bg-[#5cb85c] text-[#fff] rounded">
                        {{ $t(`customer_view.enable`) }}
                    </button>
                </div>
                <div v-if="customerView.status == 2" class="flex">
                    <div class="text-[#8a6d3b] mr-6 text-center">{{ customerView.statusUnconfirm }}</div>
                </div>
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.sent_by_email`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                <div v-if="customerView.registerReceiveEmail" class="flex">
                    <div class="text-[#5cb85c] mr-6 text-center">{{ customerView.signUpReceiveEmail }}</div>
                    <button @click="change"
                        class="px-[5px] py-[1px] text-[#d43f3a] border border-red-300 rounded hover:bg-[#d43f3a] hover:text-[#fff]">
                        {{ $t(`customer_view.stop`) }}
                    </button>
                </div>
                <div v-if="!customerView.registerReceiveEmail" class="flex">
                    <div class="text-[#8a6d3b] mr-6 text-center">{{ customerView.refuseReceiveEmail }}</div>
                    <button @click="change"
                        class="px-[5px] py-[1px] border border-gray-300 bg-[#5cb85c] text-[#fff] rounded">
                        {{ $t(`customer_view.subscribe`) }}
                    </button>
                </div>
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.credit_card`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.creditCard }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.money_total`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.moneyTotal }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.last_event`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.lastEvent }}
            </div>
            <div class="w-[16.67%] px-[5px] py-[10px] border border-gray-300 bg-[#ececec] text-[12px] font-medium">
                {{ $t(`customer_view.vote`) }}
            </div>
            <div class="w-[33.33%] px-[5px] py-[10px] border border-gray-300 text-[12px]">
                {{ customerView.vote }}
            </div>
        </div>
        <teleport to="body">
            <modal v-if="isShowModalStatus" @closeModal="onCloseModal">
                <template v-slot:title>
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray break-all">
                            {{ $t("customer_view.header_modal") }}
                        </h3>
                    </div>
                </template>
                <template v-slot:content>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed break-all">
                            {{ $t("customer_view.content_status") }}
                        </p>
                    </div>
                </template>
                <template v-slot:foot>
                    <div class="flex items-center justify-end p-6 space-x-2 rounded-b break-all">
                        <button @click="onCloseModal"
                            class="text-[#2563eb] bg-[#ffffff] border-2 border-gray-500 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("customer_view.cancel") }}
                        </button>
                        <button @click="onModalConfirmStatus(!customerView.status)"
                            class="text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("customer_view.access") }}
                        </button>
                    </div>
                </template>
            </modal>
        </teleport>
        <teleport to="body">
            <modal v-if="isShowModalRegister" @closeModal="onCloseModal">
                <template v-slot:title>
                    <div class="flex justify-between items-start p-4 rounded-t border-b dark:border-gray-100">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray break-all">
                            {{ $t("customer_view.header_modal") }}
                        </h3>
                    </div>
                </template>
                <template v-slot:content>
                    <div class="p-6 space-y-6">
                        <p class="text-base leading-relaxed break-all">
                            {{ $t("customer_view.content_register") }}
                        </p>
                    </div>
                </template>
                <template v-slot:foot>
                    <div class="flex items-center justify-end p-6 space-x-2 rounded-b break-all">
                        <button @click="onCloseModal"
                            class="text-[#2563eb] bg-[#ffffff] border-2 border-gray-500 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("customer_view.cancel") }}
                        </button>
                        <button @click="onModalConfirmRegister(!customerView.registerReceiveEmail)"
                            class="text-white bg-blue-600 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2 break-all">
                            {{ $t("customer_view.access") }}
                        </button>
                    </div>
                </template>
            </modal>
        </teleport>
        <div class="table-container mt-[3%]">
            <h1 style="font-size: 17px; font-weight: 600">{{ $t("customer_view.reserve") }}</h1>
            <ReservationsManageTable :dataTable="dataTableExample" />
        </div>
        <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total"
            @onBack="handleNextPage" @onNext="handleNextPage" />
    </div>
</template>

<script>
import { inject, ref, reactive, watch } from "vue";
import { useRoute } from "vue-router";
import Modal from "@/views/ReservationsCalendar/child/Modal.vue";
import {
    getCustomerDetailFromApi,
    putCustomerStatusFromApi,
    putCustomerReceiveEmailFromApi,
    getReservationByCondition,
} from "@/api";
import { convertDateByTimestamp, convertDateOfBirth } from "@/utils";
import ReservationsManageTable from "@/components/ReservationsManage/ReservationsManageTable.vue";
import { useStore } from "vuex";
import { ROUTER_PATH, MODULE_STORE } from "@/const";
import Pagination from "@/components/Pagination";
import moment from "moment";
import { useI18n } from "vue-i18n";

export default {
    name: "CustomerView",
    components: { Modal, ReservationsManageTable, Pagination },
    setup() {
        const isShowModalStatus = ref(false);
        const isShowModalRegister = ref(false);
        const customerView = ref({});
        const route = useRoute();
        const store = useStore();
        const { t } = useI18n();
        const toast = inject("$toast");
        const changeDisable = () => {
            isShowModalStatus.value = true;
        };
        const pagination = ref(null);
        const customerId = route.params.id;
        const statusCurrent = ref(null);

        const onModalConfirmStatus = async (status) => {
            try {
                await putCustomerStatusFromApi(customerId, { is_active: status });
                const customer = await getCustomerDetailFromApi(customerId);
                customerView.value.status = customer.status;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            isShowModalStatus.value = false;
        };
        const onCloseModal = () => {
            isShowModalStatus.value = false;
            isShowModalRegister.value = false;
        };
        const change = () => {
            isShowModalRegister.value = true;
        };
        const onModalConfirmRegister = async (isReceive) => {
            try {
                await putCustomerReceiveEmailFromApi(customerId, { is_receiving_reservation_email: isReceive });
                const customer = await getCustomerDetailFromApi(customerId);
                customerView.value.registerReceiveEmail = customer.news_letter_subscribed;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            isShowModalRegister.value = false;
        };

        const getCustomerView = async (id) => {
            try {
                const response = await getCustomerDetailFromApi(id);
                customerView.value = {
                    id: response?.customer_id || "",
                    memberType: response?.membership_type || "",
                    name: response?.first_name || "",
                    gender: response?.gender || "",
                    dateBirthday: response.birthday ? convertDateOfBirth(response?.birthday) : "",
                    nameConpany: response?.company_name || "",
                    nameConpany_Kana: response?.company_name_kana || "",
                    telephoneNumber: response?.phone_number || "",
                    email: response.email,
                    address: response?.address || "",
                    dateRegister: convertDateByTimestamp(response?.registration_date) || "",
                    status: response?.status || false,
                    refuseReceiveEmail: "停止中 ",
                    signUpReceiveEmail: "購読中",
                    registerReceiveEmail: response.news_letter_subscribed || false,
                    creditCard: response?.credit_card_information || "N/A",
                    moneyTotal: response?.total_price_sans_tax,
                    lastEvent: response?.latest_activity || "N/A",
                    vote: response?.number_of_reviews || "口コミはありません",
                    statusTrue: "有効 ",
                    statusFalse: "無効 ",
                    statusUnconfirm: "未確認",
                };
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
        };
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
                    const nameKana =
                        item.rental_space?.rental_space_eav?.find((item) => item.attribute == "generalBasicSpaceNameKana")?.value ||
                        "";
                    const spaceName = nameJa + " " + nameKana;
                    return [
                        {
                            text: item.id,
                            type: "links",
                            url: `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.RESERVATIONS}/${ROUTER_PATH.RESERVATIONS_CONFIRMATION}?idReservation=${item.id}`,
                        },
                        {
                            text: item?.user
                                ? item?.user?.first_name + item?.user?.last_name + `(${item.people_count})`
                                : item?.customer?.first_name + item?.customer?.last_name + `(${item.people_count})`,
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

        const getReservationByConditionFromApi = async (params) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

                const queryParams = route.query;

                const params = {
                    byUserBooking: queryParams?.byUser ? "byUser" : "byCustomer",
                    idUserBooking: customerId,
                };

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

        getCustomerView(customerId);

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
        const convertGender = (value) => {
            if (value == "unspecified") {
                return value ? t("list_customer_page.unspecified") : "";
            }
            if (value == "male") {
                return value ? t("list_customer_page.male") : "";
            }
            if (value == "female") {
                return value ? t("list_customer_page.Female") : "";
            }
        };
        const convertMemberType = (value, isSearch) => {
            return value ? t("list_customer_page.transient") : "";
        };

        return {
            dataTableExample,
            getReservationByConditionFromApi,
            pagination,
            handleBackPage,
            handleNextPage,
            customerView,
            isShowModalStatus,
            changeDisable,
            onModalConfirmStatus,
            onCloseModal,
            isShowModalRegister,
            change,
            onModalConfirmRegister,
            statusCurrent,
            handleFilterStatus,
            convertGender,
            convertMemberType,
        };
    },
};
</script>

<style></style>
