<template>
    <div class="p-3">
        <div class="flex h-8 justify-between mt-1">
            <ButtonFilter @clickBtn="handleClickSortFn" />
            <ButtonDownloadCSV @onExportFile="handleExportFile" />
        </div>
        <div class="my-4 border-b pl-4 pb-4" v-show="isShowSort">
            <FormKit type="group" v-model="filterKey">
                <div class="w-full flex items-center my-2">
                    <div class="mr-20 w-32">
                        <i class="fa fa-sort"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.sort_by") }}
                        </span>
                    </div>
                    <FormKit type="select" name="provind" :options="optionsSelectSortBy"
                        input-class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50"
                        class="" />
                </div>
                <div class="flex items-center my-2">
                    <div class="mr-20 w-32">
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.name") }}
                        </span>
                    </div>
                    <FormKit name="street" type="text"
                        input-class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                </div>
                <div class="flex items-center my-2">
                    <div class="mr-20 w-32">
                        <i class="fa fa-envelope-o"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.email_address") }}
                        </span>
                    </div>
                    <FormKit name="street1" type="text"
                        input-class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                </div>

                <div class="flex items-center my-2">
                    <div class="mr-20 w-32">
                        <i class="fa fa-phone"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.phone_number") }}
                        </span>
                    </div>
                    <FormKit label="" name="street2" type="text"
                        input-class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                </div>
                <div class="flex items-center my-2">
                    <div class="mr-20 w-32">
                        <i class="fa fa-map-o"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.address") }}
                        </span>
                    </div>
                    <FormKit type="select" name="state" :options="optionsSelectProvin"
                        input-class="bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg  focus:shadow-cyan-500/50 focus:border-cyan-500/50" />
                </div>
                <div class="flex items-center my-4">
                    <div class="mr-20 w-32">
                        <i class="fa fa-level-up"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.user_type") }}
                        </span>
                    </div>
                    <FormKit type="checkbox" label="" :options="radioUserType" wrapper-class="flex" options-class="flex"
                        outer-class="w-96" label-class="text-sm font-bold ml-1 mr-4" />
                </div>

                <div class="flex items-center my-4">
                    <div class="mr-20 w-32">
                        <i class="fa fa-level-up"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.email_newsletter") }}
                        </span>
                    </div>
                    <FormKit type="radio" label="" :options="radioEmailNewleter" wrapper-class="flex"
                        options-class="flex" outer-class="w-96" label-class="text-sm font-bold ml-1 mr-4" />
                </div>

                <div class="flex items-center my-4">
                    <div class="mr-20 w-32">
                        <i class="fa fa-level-up"></i>
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.status") }}
                        </span>
                    </div>
                    <FormKit type="radio" label="" :options="radioStatus" wrapper-class="flex" options-class="flex"
                        outer-class="w-96" label-class="text-sm font-bold ml-1 mr-4" />
                </div>

                <div class="flex items-center my-4">
                    <div class="mr-20 w-32">
                        <span class="font-bold text-sm">
                            {{ $t("list_customer_dropdown.registration_date_period") }}
                        </span>
                    </div>

                    <div class="flex h-8 border rounded mr-4">
                        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div
                            class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
                            {{ $t("list_customer_dropdown.start_date") }}
                        </div>
                        <div class="flex items-center justify-center">
                            <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="startDatePicker"
                                :readonly="false" />
                        </div>
                    </div>

                    <div class="flex h-8 border rounded">
                        <div class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] flex items-center justify-center">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <div
                            class="h-full px-2 bg-[#eee] border-r border-[#dbdbdb] text-sm flex items-center justify-center">
                            {{ $t("list_customer_dropdown.end_date") }}
                        </div>
                        <div class="flex items-center justify-center">
                            <datepicker class="px-2 w-40 outline-none text-center text-sm" v-model="endDatePicker"
                                :readonly="false" />
                        </div>
                    </div>
                </div>
            </FormKit>
            <button @click="getListCustomerAndSetPage(true)"
                class="px-2 py-1 rounded hover:bg-[rgba(0,0,0,.06)] border mt-3">
                <i class="fa fa-search mr-2" aria-hidden="true"></i>
                <span class="text-sm">
                    {{ $t("list_customer_dropdown.search") }}
                </span>
            </button>
        </div>
        <div class="mt-4">
            <table class="w-full">
                <thead>
                    <tr class="border-y-2">
                        <th class="border py-1 text-left px-1 w-[15%]">
                            {{ $t("list_customer_page.email_address") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[15%]">
                            {{ $t("list_customer_page.name") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[10%]">
                            {{ $t("list_customer_page.phone_number") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[10%]">
                            {{ $t("list_customer_page.sex") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[10%]">
                            {{ $t("list_customer_page.birthDay") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[5%]">
                            {{ $t("list_customer_page.address") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[5%]">
                            {{ $t("list_customer_page.review_number") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[10%]">
                            {{ $t("list_customer_page.member_type") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[5%]">
                            {{ $t("list_customer_page.status") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[12%]">
                            {{ $t("list_customer_page.registration_date") }}
                        </th>
                        <th class="border py-1 text-left px-1 w-[5%]">
                            {{ $t("list_customer_page.money_total") }}
                        </th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in listCustomerPage" :key="item.customer_id" class="even:bg-zinc-100">
                        <td class="border text-sm text-left px-1">
                            <router-link :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CUSTOMER_VIEW}/${item.customer_id}`">
                                <span class="text-[#337ab7] cursor-pointer break-all">
                                    {{ item.email }}
                                </span>
                            </router-link>
                        </td>
                        <td class="border text-sm text-left px-1">
                            <router-link :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CUSTOMER_VIEW}/${item.customer_id}`">
                                <span class="text-[#337ab7] cursor-pointer break-all">
                                    {{ item.first_name }} {{ item.last_name }}
                                </span>
                            </router-link>
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ item.phone_number }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ item.status != 2 ? convertGender(item.gender) : "" }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ item.birthday }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ item.address }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ item.number_of_reviews }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            {{ convertMemberType(item.membership_type) }}
                        </td>
                        <td class="border text-sm text-left px-1 break-all">
                            <div class="text-[#3c763d]" v-if="item.status == 1">
                                {{ convertStatus(item.status) }}
                            </div>
                            <div class="text-[#d43f3a]" v-if="item.status == 0">
                                {{ convertStatus(item.status) }}
                            </div>
                            <div class="text-[#8a6d3b]" v-if="item.status == 2">
                                {{ convertStatus(item.status) }}
                            </div>
                        </td>
                        <td class="border text-sm text-left break-all">
                            {{ item.registration_date }}
                        </td>
                        <td class="border text-sm text-left break-all">
                            {{ item.total_price_sans_tax }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total"
                @onBack="handleBackPage" @onNext="handleNextPage" :isShowNext="isShowNext" :isShowPrev="isShowPrev" />
        </div>
    </div>
</template>

<script>
import Datepicker from "vue3-datepicker";
import ButtonFilter from "@/components/Buttons/ButtonFilter";
import ButtonDownloadCSV from "@/components/Buttons/ButtonDownloadCSV";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT } from "@/const";
import { optionsSelectProvin, optionsSelectSortBy } from "@/const/options";
import { getListCustomerFromApi } from "@/api";
import { convertDateByTimestamp, convertDateOfBirth } from "@/utils";
import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import { ref, computed, watch, inject } from "vue";
import Pagination from "@/components/Pagination";
import { useI18n } from "vue-i18n";
export default {
    name: "ListCustomer",
    components: {
        Datepicker,
        ButtonFilter,
        ButtonDownloadCSV,
        Pagination,
    },

    setup(props, context) {
        const filterKey = ref({});
        const isShowSort = ref(false);
        const startDatePicker = ref();
        const endDatePicker = ref();
        const listCustomerPage = ref([]);
        const pagination = ref(null);
        const route = useRoute();
        const { t } = useI18n();
        const router = useRouter();
        const store = useStore();
        const toast = inject("$toast");
        const radioUserType = {
            value1: "本会員",
            value2: "仮会員（会員登録無しで予約",
            value3: "退会済み",
        };
        const radioEmail = {
            value1: "あり",
            value2: "なし",
            value3: "すべて",
        };
        const radioPhone = {
            value1: "あり",
            value2: "なし",
            value3: "すべて",
        };
        const radioEmailNewleter = {
            value1: "受け取る",
            value2: "受け取らない",
            value3: "すべて",
        };
        const radioStatus = {
            value1: "有効",
            value2: "無効",
            value3: "未確認",
        };
        const pageCurrent = computed(() => {
            if (!route.query.page) {
                return PAGE_DEFAULT;
            }
            return Number(route.query.page);
        });

        const isShowNext = computed(() => pageCurrent.value < pagination.value.total);
        const isShowPrev = computed(() => pageCurrent.value > 1);

        const handleClickSortFn = () => {
            isShowSort.value = !isShowSort.value;
        };
        const handleExportFile = () => {
            const download = function (data) {
                const blob = new Blob([data], { type: "text/csv;" });

                const url = window.URL.createObjectURL(blob);

                const a = document.createElement("a");

                a.setAttribute("href", url);

                a.setAttribute("download", "ts_customer_admin.csv");

                a.click();
            };

            const csvMaker = function (listCustomerPage) {
                const header =
                    "ID,メールアドレス,名前,電話番号,性別,生年月日,住所,	口コミ数,	会員タイプ,ステータス,会員登録日,合計";
                const listCustomerPageConvert = listCustomerPage
                    .map(
                        (item) =>
                            `${item.customer_id},${item.email},${item.first_name_kana},${item.phone_number},${convertGender(
                                item.gender
                            )},${item.birthday},${item.address},${item.number_of_reviews},${convertMemberType(
                                item.membership_type
                            )},${convertStatus(item.status)}${item.registration_date}${item.total_price_sans_tax}`
                    )
                    .join("\n");
                return `${header}\n${listCustomerPageConvert}`;
            };

            const get = async function () {
                const csvData = csvMaker(listCustomerPage.value);
                download(csvData);
            };

            get.bind()();
        };
        const convertStatus = (value) => {
            return value == 1 ? t("list_customer_page.effect") : value == 0 ? t("list_customer_page.no_effect") : "未確認";
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
        const getListCustomerAndSetPage = (isSearch) => {
            pageCurrent.value = 1;
            getListCustomer(isSearch);
        };

        const getListCustomer = async (isSearch) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                let filter = {};
                let data = {};
                if (isSearch) {
                    let membership_type_array = [];
                    if (filterKey.value.checkbox_4?.length) {
                        filterKey?.value?.checkbox_4.forEach((item) => {
                            if (item == "value1") {
                                membership_type_array.push("permanent");
                            }
                            if (item == "value2") {
                                membership_type_array.push("transient");
                            }
                            if (item == "value3") {
                                membership_type_array.push("deleted");
                            }
                        });
                    }
                    filter = {
                        first_name: filterKey.value.street,
                        email: filterKey.value.street1,
                        address: filterKey.value.state == "option1" ? "" : optionsSelectProvin[filterKey.value.state],
                        phone_number: filterKey.value.street2,
                        email_status:
                            filterKey.value.radio_5 == "value1" ? "notNull" : filterKey.value.radio_5 == "value2" ? "null" : "",
                        phone_number_status:
                            filterKey.value.radio_6 == "value1" ? "notNull" : filterKey.value.radio_6 == "value2" ? "null" : "",
                        registration_date_start: startDatePicker.value ? formatDate(startDatePicker.value) : "",
                        registration_date_end: endDatePicker.value ? formatDate(endDatePicker.value) : "",

                        created_at: filterKey.value.provind == "ops1" ? "desc" : filterKey.value.provind == "ops4" ? "asc" : "",
                        e_mail_magazine: filterKey.value.radio_7 == "value1" ? 1 : filterKey.value.radio_7 == "value2" ? 0 : "",
                        status:
                            filterKey.value.radio_8 == "value1"
                                ? 1
                                : filterKey.value.radio_8 == "value2"
                                    ? 0
                                    : filterKey.value.radio_8 == "value3"
                                        ? 2
                                        : "",
                        number_of_reviews: filterKey.value.provind == "ops3" ? true : "",
                        total_fee: filterKey.value.provind == "ops2" ? true : "",
                        membership_type: membership_type_array,
                    };
                    data = { filter: filter, page: pageCurrent.value };
                } else {
                    data = { filter: filter, page: pageCurrent.value };
                }
                const response = await getListCustomerFromApi(data);
                pagination.value = response.pagination;
                listCustomerPage.value = response.data.map((item) => {
                    return {
                        ...item,
                        registration_date: convertDateByTimestamp(item.registration_date),
                        birthday: convertDateOfBirth(item.birthday),
                    };
                });
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        watch(pageCurrent, (page) => {
            getListCustomer(true);
        });

        const handleBackPage = (page) => {
            router.push(`${ROUTER_PATH.LIST_CUSTOMER}?page=${page}`);
        };
        const handleNextPage = (page) => {
            router.push(`${ROUTER_PATH.LIST_CUSTOMER}?page=${page}`);
        };
        getListCustomer();
        function formatDate(date) {
            var d = new Date(date),
                month = "" + (d.getMonth() + 1),
                day = "" + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2) month = "0" + month;
            if (day.length < 2) day = "0" + day;

            return [year, month, day].join("-");
        }
        return {
            filterKey,
            isShowSort,
            endDatePicker,
            startDatePicker,
            handleClickSortFn,
            getListCustomer,
            listCustomerPage,
            optionsSelectProvin,
            optionsSelectSortBy,
            radioUserType,
            radioEmail,
            radioPhone,
            radioEmailNewleter,
            radioStatus,
            pagination,
            pageCurrent,
            handleBackPage,
            handleNextPage,
            ROUTER_PATH,
            handleExportFile,
            convertStatus,
            convertGender,
            convertMemberType,
            isShowNext,
            isShowPrev,
            getListCustomerAndSetPage,
            PAGE_DEFAULT
        };
    },
};
</script>

<style scoped></style>
