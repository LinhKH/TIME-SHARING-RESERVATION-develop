<template>
    <div class="error text-[#a94442] bg-[#f0d8db] border border-solid border-[#f0d8db] px-[5px] py-[10px] mb-[10px]"
        v-if="isValueDate">
        見学日時を選択してください。
    </div>
    <div>
        <div>
            <table class="table w-full border border-solid border-black border-collapse" cellspacing="1">
                <thead>
                    <tr>
                        <th class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]"
                            v-for="(tourHeader, index) in tourHeaders" scope="col" :key="index">
                            {{ tourHeader }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(tourItem, index) in listTours" :key="index" class="odd:bg-[#fffaf4]">
                        <th class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]"
                            scope="row">
                            <router-link :to="{ name: 'TourDetail', params: { id: tourItem.id } }">
                                <div class="text-[#337ab7] hover:text-[#23527c] cursor-pointer hover:underline">
                                    {{ tourItem.id }}
                                </div>
                            </router-link>
                        </th>
                        <td
                            class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px] text-start">
                            {{ tourItem.visitor_name }}
                        </td>
                        <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
                            {{ tourItem.space_name }}
                        </td>
                        <td
                            class="tour__content border border-solid border-black border-collapse p-2.5 text-center min-w-[160px] text-start">
                            <div class="tour__content-list">
                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t(`tour_manager.date`) }}</span>

                                    <ChoiceDateVue :option="tourItem" @changeChoiceDate="handleChangeDate"
                                        @confirmChoiceDate="confirmChoiceDate" />
                                </div>

                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t("tour_manager.preferred_time") }}</span>{{
                                        tourItem.use_plans_date }}
                                </div>
                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t("tour_manager.number_people") }}</span>{{
                                        tourItem.use_plans_people }}名
                                </div>
                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t("tour_manager.purpose_use") }}</span>{{
                                        tourItem.use_purpose }}
                                </div>
                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t("tour_manager.purpose_detail") }}</span>{{
                                        tourItem.use_purpose_detail }}
                                </div>
                                <div class="tour__content-item mb-2.5">
                                    <span class="text-[#333] font-bold">{{ $t("tour_manager.space_check") }}</span>{{
                                        tourItem.checklist }}
                                </div>
                            </div>
                        </td>
                        <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
                            <!-- <p>{{ replaceStatus(tourItem.status) }}</p> -->
                            <p v-if="tourItem.status === 'pending_request'">オーナー回答待ち</p>
                            <p v-if="tourItem.status === 'fix_date_time'">日時確定</p>
                            <p v-if="tourItem.status === 'waiting_response_user'">ユーザー回答待ち</p>
                            <p v-if="tourItem.status === 'user_cancel'">利用者キャンセル</p>
                            <p v-if="tourItem.status === 'change_date_time'">日時変更</p>
                            <p v-if="tourItem.status === 'observation_NG'">見学NG</p>

                            <div v-if="tourItem.status === 'change_date_time'">
                                <div class="my-[5px]">
                                    <p class="text-[#ccc] text-[12px]">{{ $t("tour_detail.cancellation_reason") }}</p>
                                    ご希望の日程では、ご見学いただけません
                                </div>
                                <div class="my-[5px]">
                                    <p class="text-[#ccc] text-[12px]">{{ $t("tour_detail.alternate_date_and_time") }}
                                    </p>
                                    <p>{{ tourItem.substitute_first_choice_date }}</p>
                                    <p>{{ tourItem.substitute_second_choice_date }}</p>
                                    <p>{{ tourItem.substitute_third_choice_date }}</p>
                                </div>
                                <p class="text-[#ccc] text-[12px]">
                                    {※ お客様が代替日時をご希望の場合は、新たに見学リクエストを送信頂くようにお伝えしております。
                                </p>
                            </div>
                            <div v-if="tourItem.status === 'fix_date_time'">
                                <div v-if="tourItem.status === 'fix_date_time'">
                                    <div v-if="
                                        tourItem.fix_choice_date_column_name === 'first_choice_date' ||
                                        tourItem.fix_choice_date_column_name === 'second_choice_date' ||
                                        tourItem.fix_choice_date_column_name === 'third_choice_date'
                                    "></div>
                                    <div v-else>
                                        <p class="text-[#ccc] text-[12px]">代替日時</p>
                                        <div>{{ tourItem.fix_choice_date_column_name }} {{
                                            tourItem.fix_choice_time_column_name }}</div>
                                        <p class="text-[#ccc] text-[12px]">
                                            ※ お客様が代替日時をご希望の場合は、新たに見学リクエストを送信頂くようにお伝えしております。
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div v-if="tourItem.status === 'observation_NG'">
                                <p class="text-[#ccc] text-[12px]">キャンセル理由</p>
                                <p>ご希望の用途では、ご利用できません。</p>
                            </div>
                        </td>
                        <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
                            <button v-if="tourItem.status === 'pending_request'"
                                @click="() => approvalConfirm(tourItem)"
                                class="button btn-approval min-w-[110px] py-2.5 px-9 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#52c195]">
                                {{ $t("tour_manager.approval") }}
                            </button>
                            <button v-if="tourItem.status !== 'user_cancel'"
                                @click="() => alternativeCalender(tourItem)"
                                class="button btn-non-approval min-w-[110px] py-2.5 px-9 border border-solid border-[#ccc] rounded mb-1 text-[#fff] cursor-pointer bg-[#8f8f8f]">
                                {{ $t("tour_manager.non-approval") }}
                            </button>
                        </td>
                        <td class="border border-solid border-black border-collapse p-2.5 text-center min-w-[160px]">
                            {{ tourItem.entry_time }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination v-if="pagination" :pageCurrent="pagination.current_page" :totalPage="pagination.total_page"
                @onBack="handleBackPage" @onNext="handleNextPage" />
        </div>
    </div>
</template>
<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { getAllListTourApi } from "@/api";
import ChoiceDateVue from "./ChoiceDate.vue";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, watch, inject } from "vue";
import Pagination from "@/components/Pagination";
import choiceDateConfirm from "./choiceDateConfirm.vue";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";

export default {
    name: "TableAccess",
    components: {
        ChoiceDateVue,
        Pagination,
        choiceDateConfirm,
    },
    props: {
        isShowSuccess: Boolean,
        checkDate: String,
    },
    setup(props, { emit }) {
        const dates = ref([]);
        const store = useStore();
        const { t } = useI18n();
        const route = useRoute();
        const listTours = ref([]);
        const pagination = ref(null);
        const toast = inject("$toast");
        const router = useRouter();
        const tour_date = ref();
        const isValueDate = ref(false);
        const tourHeaders = [
            t("tour_manager.id_tour"),
            t("tour_manager.user_visit"),
            t("tour_manager.space_name"),
            t("tour_manager.space_content"),
            t("tour_manager.status"),
            t("tour_manager.action"),
            t("tour_manager.time_entry"),
        ];
        const pageCurrent = computed(() => {
            if (!route.query.page) {
                return PAGE_DEFAULT || 1;
            }
            return Number(route.query.page);
        });
        watch(pageCurrent, (page) => {
            if (route.path !== ROUTER_PATH.TOUR) {
                getAllListTour(page);
            }
        });
        const replaceStatus = (stringValue) => {
            return stringValue.replace(/_/g, " ");
        };
        const getAllListTour = async (page = PAGE_DEFAULT) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getAllListTourApi(page);
                listTours.value = res.data;
                pagination.value = res.pagination;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const handleBackPage = (page) => {
            router.push(`${ROUTER_PATH.TOUR}?page=${page}`);
        };
        const handleNextPage = (page) => {
            router.push(`${ROUTER_PATH.TOUR}?page=${page}`);
        };
        const approvalConfirm = (item) => {
            listTours.value.forEach((el) => {
                if (el.id === item.id) {

                    if (el.tourDate) {
                        isValueDate.value = false;
                        store.commit(`tour/setTourDetailItem`, item);
                        router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}/${ROUTER_PATH.APPROVAL_CONFIRM_TOUR}`);
                    } else {
                        isValueDate.value = true;
                    }
                }
            });
        };
        const alternativeCalender = (item) => {
            store.commit(`tour/setTourDetailItem`, item);
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.TOUR}/${ROUTER_PATH.NON_APPROVAL_CONFIRM_TOUR}`);
        };
        getAllListTour(pageCurrent);
        const handleChangeDate = (date) => {
            tour_date.value = date;
        };
        const confirmChoiceDate = (date, id) => {
            isValueDate.value = false;
            listTours.value.forEach((item) => {
                if (item.id === id) {
                    item.tourDate = date;
                } else {
                    item.tourDate = "";
                }
            });
        };
        return {
            tourHeaders,
            listTours,
            pagination,
            dates,
            pageCurrent,
            handleBackPage,
            handleNextPage,
            handleChangeDate,
            getAllListTour,
            approvalConfirm,
            alternativeCalender,
            tour_date,
            ROUTER_PATH,
            BOOLEAN,
            replaceStatus,
            confirmChoiceDate,
            isValueDate,
        };
    },
};
</script>
<style></style>
