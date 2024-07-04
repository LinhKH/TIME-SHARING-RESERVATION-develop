<template>
    <div>
        <div class="text-[18px] border-b border-solid border-[#ccc] my-5 pb-6">予約 #{{ infoReservation.id }}</div>

        <div class="my-4" v-for="(tables, indexTables) in dataReservationConfirmation" :key="indexTables">
            <div class="flex items-center">
                <i :class="`${tables.icon} mr-1 text-[18px]`"></i>
                <span class="text-[18px] font-bold">{{ tables.title }}</span>
            </div>
            <div class="my-2" v-for="(table, indexTable) in tables.tables" :key="indexTable">
                <div class="" v-for="(row, indexRow) in table" :key="indexRow">
                    <div class="flex">
                        <div class="flex-1 flex" v-for="(col, indexCol) in row" :key="indexCol">
                            <div class="p-2 min-w-[270px] bg-[#ececec] border border-solid border-[#ddd]">
                                {{ col.label }}
                            </div>
                            <div class="p-2 flex-1 border border-solid border-[#ddd]">
                                <template v-if="col.type">
                                    <div class="" v-if="col.type === TYPE.status">
                                        <div class="">
                                            <!-- check status reservation -->
                                            <i class="fa fa-university mr-1"
                                                v-if="!infoReservation.status || infoReservation.status === 'pending-approval-from-owner'"></i>
                                            <i class="fa fa-money mr-1"
                                                v-if="infoReservation.status === 'waiting-for-card-information-input'"></i>
                                            <i class="fa fa-check mr-1"
                                                v-if="infoReservation.status === 'completed-cash-payment'"></i>
                                            <i class="fa fa-remove mr-1"
                                                v-if="infoReservation.status === 'reservation-request-canceled'"></i>
                                            <i class="fa fa-check mr-1"
                                                v-if="infoReservation.status === 'reservation-by-proxy: Waiting for supervisor-approval'"></i>

                                            <span
                                                v-if="!infoReservation.status || infoReservation.status === 'pending-approval-from-owner'"
                                                class="text-[#8a6d3b]">{{
                                                    $t("reservation_confirmation.pending_approval") }}</span>
                                            <span
                                                v-else-if="infoReservation.status === 'waiting-for-card-information-input'"
                                                class="text-[#31708f]">{{
                                                    $t("reservation_confirmation.waiting_for_card_information_input")
                                                }}</span>
                                            <span v-else-if="infoReservation.status === 'completed-cash-payment'"
                                                class="text-[#3c763d]">{{
                                                    $t("reservation_confirmation.completed_cash_payment")
                                                }}</span>

                                            <span v-else-if="infoReservation.status === 'reservation-request-canceled'"
                                                class="text-[#a94442]">{{
                                                    $t("reservation_confirmation.reservation_request_canceled") }}</span>
                                            <span
                                                v-else-if="infoReservation.status === 'reservation-by-proxy: Waiting for supervisor-approval'"
                                                class="text-[#3c763d]">支払い完了</span>
                                        </div>

                                        <!-- <div class="mt-1" v-if="checkType === 'admin'"> -->
                                        <div class="mt-1">
                                            <button
                                                v-if="!infoReservation.status || infoReservation.status === 'pending-approval-from-owner'"
                                                class="rounded p-1 text-white bg-[#37a200] mr-1"
                                                @click="isShowModalConfirm = true">
                                                {{ $t("reservation_confirmation.approve") }}
                                            </button>
                                            <button
                                                v-if="infoReservation.status === 'waiting-for-card-information-input'"
                                                class="rounded p-1 text-white bg-[#37a200] mr-1"
                                                @click="isShowModalConfirm = true">
                                                {{
                                                    $t("reservation_confirmation.button.waiting_for_card_information_input")
                                                }}
                                            </button>
                                            <button
                                                v-if="!infoReservation.status || infoReservation.status === 'pending-approval-from-owner'"
                                                class="rounded p-1 text-white bg-[#d43f3a]"
                                                @click="isShowModalDenyRequest = true">
                                                {{ $t("reservation_confirmation.deny_request") }}
                                            </button>
                                            <button
                                                v-if="infoReservation.status !== 'pending-approval-from-owner' && infoReservation.status !== 'reservation-by-proxy: Waiting for supervisor-approval'"
                                                class="rounded p-1 text-white bg-[#d43f3a]"
                                                @click="isShowModalCancelRequest = true">
                                                {{ $t("reservation_calendar.modal.cancel") }}
                                            </button>
                                            <button
                                                v-if="infoReservation.status === 'reservation-by-proxy: Waiting for supervisor-approval'"
                                                class="rounded p-1 text-white bg-[#d43f3a]"
                                                @click="isShowModalDenyRequest = true">
                                                {{ $t("reservation_confirmation.deny_request") }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="" v-if="col.type === TYPE.reservation_confirmation_email">
                                        <InputText class="w-3/5 h-8" />
                                        <div class="mt-1 text-[#337ab7] hover:underline cursor-pointer"
                                            @click="isShowModalPreviewEmail = true">
                                            {{ $t("reservation_confirmation.see_email_preview") }}
                                        </div>
                                    </div>
                                    <div class="" v-if="col.type === TYPE.answering_questions_from_space">
                                        <InputText class="w-full h-8" />
                                    </div>
                                    <div class="" v-if="col.type === TYPE.owner_note">
                                        <InputArea rows="3" :disabled="true" class="w-full" />
                                    </div>
                                    <div class="flex items-center"
                                        v-if="col.type === TYPE.written_by_the_administrator">
                                        <InputArea rows="3" class="w-3/5" />
                                        <button class="text-white p-2 rounded ml-1 bg-[#37a200]">{{ $t("common.keep")
                                            }}</button>
                                    </div>
                                    <div class="flex items-center" v-if="col.type === TYPE.paragraph"
                                        v-html="col.html" />
                                </template>
                                <template v-else>
                                    <span> {{ col.value || "-" }}</span>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="h-14 w-full bg-[#ececec] flex items-center justify-center font-bold text-[18px]">
            {{ $t("reservation_confirmation.message_history") }}
        </div>

        <div class="mt-4">
            <label for="" class="block mb-2">{{ $t("reservation_confirmation.no_inquiries") }}</label>
            <textarea rows="5"
                class="w-full p-2 resize-none border border-solid border-[#ddd] outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"></textarea>
        </div>
    </div>

    <ModalConfirmApprove v-if="isShowModalConfirm" :infoReservation="infoReservation"
        @close="isShowModalConfirm = false" @updateStatus="getInfoReservation" />
    <ModalDenyRequest v-if="isShowModalDenyRequest" :infoReservation="infoReservation"
        @close="isShowModalDenyRequest = false" @updateStatus="getInfoReservation" />
    <RequestingCancellation v-if="isShowModalCancelRequest" :infoReservation="infoReservation"
        @close="isShowModalCancelRequest = false" @updateStatus="getInfoReservation" />
    <ModalPreviewEmail v-if="isShowModalPreviewEmail" @close="isShowModalPreviewEmail = false" />
</template>

<script>
import InputText from "@/components/Form/InputText.vue";
import InputArea from "@/components/Form/InputArea.vue";
import ModalConfirmApprove from "./ModalConfirmApprove.vue";
import ModalDenyRequest from "./ModalDenyRequest.vue";
import RequestingCancellation from "./Modal/RequestingCancellation.vue";
import ModalPreviewEmail from "./ModalPreviewEmail.vue";
import { ref, inject, computed } from "vue";
import { useRoute } from "vue-router";
import { getReservationDetail } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { MODULE_STORE } from "@/const";
import moment from "moment";

export default {
    name: "ReservationsConfirmation",
    components: {
        ModalPreviewEmail,
        ModalConfirmApprove,
        InputText,
        InputArea,
        ModalDenyRequest,
        RequestingCancellation,
    },
    setup() {
        const route = useRoute();
        const store = useStore();
        const checkType = localStorage.getItem("type");

        const toast = inject("$toast");
        const { t } = useI18n();
        const infoReservation = ref({ id: "" });
        const idReservation = route.query.idReservation;
        const spaceName = computed(() => {
            const nameJa = infoReservation.value?.rental_space?.rental_space_eav?.find(
                (item) => item.attribute == "generalBasicSpaceNameJa"
            ).value;
            //   const nameKana = infoReservation.value?.rental_space?.rental_space_eav?.find(
            //     (item) => item.attribute == "generalBasicSpaceNameKana"
            //   ).value;

            return nameJa;
        });
        const TYPE = {
            status: "status",
            reservation_confirmation_email: "reservation_confirmation_email",
            answering_questions_from_space: "answering_questions_from_space",
            owner_note: "owner_note",
            written_by_the_administrator: "written_by_the_administrator",
            paragraph: "paragraph",
        };
        const isShowModalConfirm = ref(false);
        const isShowModalDenyRequest = ref(false);
        const isShowModalPreviewEmail = ref(false);
        const isShowModalCancelRequest = ref(false);
        const dataReservationConfirmation = computed(() => [
            {
                title: "予約内容",
                icon: "fa fa-sticky-note-o",
                tables: [
                    [
                        [
                            {
                                label: "スペース名",
                                value: spaceName.value,
                            },
                        ],
                        [
                            {
                                label: "利用日時",
                                value:
                                    moment(String(infoReservation.value.creation_time)).format("YYYY年MM月DD日[\n]") +
                                    infoReservation.value.planless_start_time +
                                    "~" +
                                    infoReservation.value.planless_end_time,
                            },
                            {
                                label: "ご利用人数",
                                value: infoReservation.value.people_count,
                            },
                        ],
                        [
                            {
                                label: "利用目的",
                                value: infoReservation.value.use_purpose_category,
                            },
                            {
                                label: "利用者区分",
                                value: "法人利用",
                            },
                        ],
                        [
                            {
                                label: "利用目的詳細",
                                value: infoReservation.value.use_purpose_for_other,
                            },
                        ],
                        [
                            {
                                label: "決済方法",
                                value: hadleFilterPayment(infoReservation.value.payment_method),
                            },
                        ],
                        [
                            {
                                label: "ステータス",
                                type: TYPE.status,
                            },
                        ],
                    ],
                    [
                        [
                            {
                                label: "名前",
                                value:
                                    infoReservation.value?.customer?.first_name_kana +
                                    " " +
                                    infoReservation.value?.customer?.last_name_kana,
                            },
                            {
                                label: "性別",
                                value: infoReservation.value?.customer?.gender,
                            },
                        ],
                        [
                            {
                                label: "生年月日",
                                value: infoReservation.value?.customer?.birthday_day_ident,
                            },
                        ],
                        [
                            {
                                label: "会社名 (カナ)",
                                value: infoReservation.value?.customer?.company_name_kana,
                            },
                        ],
                        [
                            {
                                label: "電話番号",
                                value: infoReservation.value?.customer?.phone_number,
                            },
                            {
                                label: "メールアドレス",
                                value: infoReservation.value?.customer?.email,
                            },
                        ],
                        [
                            {
                                label: "申し込み日",
                                value: moment(infoReservation.value?.customer?.created_at).format("YYYY年MM月DD日[\n]hh:mm"),
                            },
                        ],
                    ],
                ],
            },
            {
                title: "ご利用料金",
                icon: "fa fa-yen",
                tables: [
                    [
                        [
                            {
                                label: "スペース料金合計（税抜）",
                                value:
                                    infoReservation.value.total_price_sans_tax +
                                    "(" +
                                    infoReservation.value.total_price_sans_tax_with_fraction +
                                    ")",
                            },
                        ],
                        [
                            {
                                label: "連続利用による割引（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "直前割引による割引（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "割引後スペース料金（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "オプション (税抜)",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "スペース料金+オプション料金合計（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "クーボン割引（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "利用料金（税抜）",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "送客手数料（税抜）",
                                value: "",
                            },
                        ],
                    ],
                ],
            },
            {
                title: "スペース利用詳細",
                icon: "fa fa-file-text-o",
                tables: [
                    [
                        [
                            {
                                label: "予スペースへの連絡事項確認メールの再送",
                                type: TYPE.reservation_confirmation_email,
                            },
                        ],
                        [
                            {
                                label: "スペースからの質問の回答",
                                type: TYPE.answering_questions_from_space,
                            },
                        ],
                        [
                            {
                                label: "スペースへの連絡事項",
                                value: "",
                            },
                        ],
                        [
                            {
                                label: "オーナー記載メモ",
                                type: TYPE.owner_note,
                            },
                        ],
                        [
                            {
                                label: "管理者記載メモ",
                                type: TYPE.written_by_the_administrator,
                            },
                        ],
                        [
                            {
                                label: "飲食手配相談",
                                value: "",
                            },
                        ],
                    ],
                ],
            },
        ]);
        const getInfoReservation = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getReservationDetail(idReservation);
                if (res.status === 200) {
                    infoReservation.value = res.data;
                }
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        getInfoReservation();

        const hadleFilterPayment = (value) => {
            switch (value) {
                case "credit-card":
                    return "クレジットカード";

                case "bank-transfer":
                    return "銀行振込";

                case "cash-on-site":
                    return "キャッシュオンサイト";

                case "other":
                    return "他の";

                case "internal-otherwise-handled":
                    return "内部その他の処理";

                case "choose-later-by-customer":
                    return "後で選択";
            }
        };

        return {
            isShowModalConfirm,
            dataReservationConfirmation,
            TYPE,
            isShowModalDenyRequest,
            isShowModalPreviewEmail,
            infoReservation,
            getInfoReservation,
            checkType,
            hadleFilterPayment,
            isShowModalCancelRequest,
        };
    },
};
</script>
