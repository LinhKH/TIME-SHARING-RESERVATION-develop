<template>
    <div class="inquiries-detail">
        <div class="inquiries-detail-information">
            <h2>{{ namespace }}</h2>
            <div class="flex">
                <Information class="w-1/2 table" :information="listInformationCompany" />
                <Information class="w-1/2 table" :information="listInformation" />
            </div>
        </div>
        <div class="inquiries-detail-message-history">
            <h2 class="mt-4">{{ $t("list_inquiries_page.message_history") }}</h2>
            <div class="grid inquiries-detail-reply">
                <MessageHistory :listReply="listReply" :isRead="isRead" />
            </div>
        </div>
        <div class="inquiries-detail-reply-message">
            <p class="warning mb-2.5" v-if="checkLastMessageCustomer">
                {{ $t("list_inquiries_page.you_have_unanswered_messages") }}
            </p>
            <div class="flex h-10">
                <div class="title w-1/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2 bg-[#ececec] font-bold">
                    {{ $t("list_inquiries_page.manager") }}
                </div>
                <div class="value w-3/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2">
                    {{ nameUser }}
                </div>
            </div>
            <div class="flex">
                <div class="title w-1/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2 bg-[#ececec] font-bold">
                    {{ $t("list_inquiries_page.reply_message") }}
                </div>
                <div class="value w-3/4 border border-[#dbdbdb] border-solid p-2.5 pl-2">
                    <textarea ref="textarea" v-model="textareaDetail"
                        class="reply-message-input border border-[#dbdbdb] border-solid rounded h-auto break-all p-2 whitespace-pre-line overflow-hidden outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50">
                    </textarea>
                    <p v-if="isCheckError" class="text-[#e33904] font-bold mb-4">
                        {{ $t("list_inquiries_page.your_answer_is_blank") }}
                    </p>
                    <div class="flex">
                        <button class="btn-submit" @click="submitForm">{{ $t("list_inquiries_page.send") }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="inquiries-detail-inquiry">
            <div class="flex">
                <div class="title w-1/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2 bg-[#ececec] font-bold">
                    {{ $t("list_inquiries_page.inquiry_completed") }}
                </div>
                <div class="value w-3/4 border border-[#dbdbdb] border-solid p-2.5 pl-2">
                    <input type="checkbox" id="1" v-model="valueSupport" @click="handleSupport()" />
                    <label for="agreeing_to_terms_id" class="font-bold ml-1 select-none">{{
                        $t("list_inquiries_page.completion")
                    }}</label>
                    <div class="mb-2.5 mt-2">
                        <p>
                            {{ $t("list_inquiries_page.check_completed_and_click") }}
                            <span @click="backToListInquiries()" class="link text-[#337ab7] block">{{
                                $t("list_inquiries_page.back_to_space_inquiry_list")
                            }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { ref, computed, watch, inject, reactive } from "vue";
import Information from "./Information.vue";
import MessageHistory from "./MessageHistory.vue";
import { MODULE_STORE, ROUTER_PATH } from "@/const";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import {
    getDetailInquiriesApi,
    getListInquiesReplyApi,
    createInquiesReplyApi,
    updateStatusSupportInquiriesApi,
    getUserProfileApi,
    updateIsReadInquiry,
} from "@/api";
import { useRouter, useRoute } from "vue-router";

export default {
    name: "InquiriesDetail",
    components: { Information, MessageHistory },
    setup(props, context) {
        const store = useStore();
        const valueSupport = ref(false);
        const { t } = useI18n();
        const listInformationCompany = ref([
            { name: "会員タイプ", value: "" },
            { name: "性別", value: "" },
            { name: "会社名", value: "" },
            { name: "電話番号", value: "" },
            { name: "住所", value: "" },
        ]);
        const listInformation = ref([
            { name: "名前", value: "" },
            { name: "生年月日", value: "" },
            { name: "会社名 (カナ)", value: "" },
            { name: "メールアドレス", value: "" },
            { name: "会員登録日", value: "" },
        ]);
        const reservationInformation = ref([
            { name: "予約完了日時", value: "2022年1月25日（火）12:54" },
            { name: "スペース名", value: "テストスペース府中" },
            { name: "ご利用日", value: "2022年2月3日（木）" },
            { name: "ご利用人数", value: "1 名" },
            { name: "合計 (税抜)", value: "6,000 円" },
            { name: "", value: "予約についての詳細" },
        ]);
        const messageHistory = ref([
            {
                id: "1",
                type: "owner",
                name: "ts-dev疋田 優人",
                date: "2022年1月28日（金）17:41",
                message: "2重問い合わせテスト2（予約詳細から）",
            },
            {
                id: "2",
                type: "owner",
                name: "ts-dev疋田 優人",
                date: "2022年1月28日（金）17:41",
                message: "テストスペース府中",
            },
            { id: "3", type: "user", name: "疋田 優人", date: "2022年1月28日（金）17:41", message: "2022年2月3日（木）" },
            { id: "4", type: "owner", name: "ts-dev疋田 優人", date: "2022年1月28日（金）17:41", message: "1 名" },
            { id: "5", type: "owner", name: "ts-dev疋田 優人", date: "2022年1月28日（金）17:41", message: "6,000 円" },
            { id: "6", type: "user", name: "疋田 優人", date: "2022年1月28日（金）17:41", message: "予約についての詳細" },
        ]);

        const router = useRouter();
        const route = useRoute();
        const toast = inject("$toast");
        const id = route.query.id;
        const isCheckError = ref("");
        const textareaDetail = ref("");
        const checkedCompletion = ref(true);
        const formData = ref({});
        const listReply = ref();
        const namespace = ref("");
        const lastAdmin = ref();
        const nameUser = ref();
        const isRead = ref(0);

        const submitForm = () => {
            if (textareaDetail.value === "") {
                isCheckError.value = true;
            } else {
                isCheckError.value = false;
                createInquiesReply(textareaDetail.value);
            }
        };
        const getInformationUser = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getUserProfileApi();
                nameUser.value = `${res?.first_name} ${res?.last_name}`;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        getInformationUser();

        const createInquiesReply = async (values) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await createInquiesReplyApi(id, {
                    description: values,
                });
                if (isRead.value) {
                    await updateIsReadInquiry(id, { is_read: 0 });
                    isRead.value = 0;
                }
                getAllListInquiryReply();
                textareaDetail.value = "";
                if (valueSupport.value) {
                    valueSupport.value = false;
                    await updateStatusSupportInquiries(0);
                }
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const getDetailInquires = async () => {
            if (id) {
                try {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                    const res = await getDetailInquiriesApi(id);
                    valueSupport.value = !!res.data.support_done;
                    formData.value = {
                        ...formData.value,
                        ...res.data,
                    };
                    listInformationCompany.value[0].value = formData.value.inquiry_typeWF;
                    listInformationCompany.value[1].value = formData.value.customer.gender;
                    listInformationCompany.value[2].value = formData.value.customer.company_name;
                    listInformationCompany.value[3].value = formData.value.customer.phone_number;
                    listInformationCompany.value[4].value = formData.value.customer.address;

                    listInformation.value[0].value = formData.value.customer.nickname;
                    listInformation.value[1].value = formData.value.customer.birthday_day_ident;
                    listInformation.value[2].value = formData.value.customer.company_name_kana;
                    listInformation.value[3].value = formData.value.customer.email;
                    listInformation.value[4].value = formData.value.customer.created_at;
                    namespace.value = res.data.namespace || "";
                    isRead.value = res.data.is_read;
                } catch (errors) {
                    const error = errors.message || t("common.has_error");
                    toast.error(error);
                } finally {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                }
            }
        };
        getDetailInquires();
        const getAllListInquiryReply = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getListInquiesReplyApi(id);
                listReply.value = res;
                lastAdmin.value = res[res?.length - 1];
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        getAllListInquiryReply();
        const handleSupport = () => {
            // convert boolean to number ( +!valueSupport.value )
            updateStatusSupportInquiries(+!valueSupport.value);
        };
        const updateStatusSupportInquiries = async (values) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

                await updateStatusSupportInquiriesApi(id, {
                    support_done: values,
                });
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const backToListInquiries = () => {
            router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.INQUIRIES}`);
        };
        const checkLastMessageCustomer = computed(() => {
            return listReply.value?.length && listReply.value[listReply.value.length - 1]?.customer_id;
        });
        return {
            id,
            formData,
            listInformationCompany,
            listInformation,
            reservationInformation,
            messageHistory,
            isCheckError,
            textareaDetail,
            checkedCompletion,
            submitForm,
            listReply,
            handleSupport,
            backToListInquiries,
            valueSupport,
            namespace,
            lastAdmin,
            nameUser,
            checkLastMessageCustomer,
            isRead,
        };
    },
};
</script>
<style lang="scss" scoped>
.inquiries-detail {
    margin: 15px;

    h2 {
        background-color: #ececec;
        font-size: 18px;
        padding: 16px;
        text-align: center;
        border-radius: 0;
        font-weight: bolder;
        margin-bottom: 10px;
    }

    .inquiries-detail-information {
        .information-reservation {
            :deep(.title) {
                width: 14.2%;
            }

            :deep(.value) {
                width: 100%;
            }
        }
    }

    .inquiries-detail-message-history {
        border: solid 1px #ddd;
        margin: 18px 0 20px;
    }

    .inquiries-detail-reply {
        //height: 500px;
        //overflow: scroll;
    }

    .inquiries-detail-reply-message {
        .warning {
            color: #c00;
            font-weight: 700;
        }

        .title {
            width: 14.2%;
        }

        .value {
            width: 100%;
        }

        .reply-message-input {
            width: 99%;
            height: 160px;
        }

        .btn-submit {
            display: inline-block;
            background: #ffbd00;
            color: #fff;
            box-shadow: 0 1px 1px #a4966e;
            border: 0;
            text-decoration: none;
            font-size: 14px;
            padding: 8px;
            margin-top: 1rem;
            border-radius: 6px;
        }

        .btn-submit:hover {
            background-color: #ffbd00;
            box-shadow: 0 1px #5f4702;
            transform: translateY(2px);
        }
    }

    .inquiries-detail-inquiry {
        .title {
            width: 14.2%;
        }

        .value {
            width: 100%;
        }
    }

    .link {
        color: #3498db;
        cursor: pointer;
    }
}
</style>
