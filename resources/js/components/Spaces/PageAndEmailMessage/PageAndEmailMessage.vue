<template>
    <HeaderSpaces :title="$t('space_page_and_email_message.title')"
        :textHelp="$t('space_page_and_email_message.textHelp')"
        :textLink="$t('spaces_image_page.preview_of_public_page')" :textHelpTop="$t('spaces_image_page.text_desc_1')" />
    <div class="pt-2">
        <LayoutInput v-for="(item, index) in optionsPageAndEmailMessage" :key="index" :labelText="item.label"
            :icon="item.icon" :isRequired="item.isRequired" customCss="mt-1">
            <div class="border border-solid border-[#ddd] w-full rounded flex">
                <div
                    class="w-11 rounded-tl rounded-bl flex items-center justify-center bg-[#eee] border-r border-solid border-[#ddd]">
                    <img :src="JapanIcon" alt="image" class="w-9 object-cover" />
                </div>
                <textarea v-model="formData[item.name]" type="text"
                    class="w-full h-14 p-1 focus:shadow-lg rounded-tr rounded-br focus:shadow-cyan-500/50 focus:border-cyan-500/50 outline-none resize-none" />
            </div>
            <MessagesForm v-if="errors[item.name]" messages="必須項目です。 " />
        </LayoutInput>
    </div>
    <ButtonNextStep :nextPage="'スペース公開申請'" @onNext="handleSubmit" @onBack="handleBack" />
</template>

<script>
import HeaderSpaces from "@/components/HeaderSpaces";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import MessagesForm from "@/components/MessagesForm";
import ButtonNextStep from "@/components/Buttons/ButtonNextStep";
import JapanIcon from "@/assets/images/japan.png";
import { MODULE_STORE, ROUTER_PATH, STEP_CREATE_SPACE, STEP_SPACE_CREATED } from "@/const";
import { optionsPageAndEmailMessage } from "@/const/options";
import { useStore } from "vuex";
import { reactive, inject, computed } from "vue";
import {
    postSpacePageAndEmailMessage,
    getDetailSpaceEmailMessage,
    getDetailSpacePage,
    getDetailSpaceGeneral,
} from "@/api";
import { useRouter, useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

export default {
    name: "PageAndEmailMessage",

    components: { HeaderSpaces, LayoutInput, ButtonNextStep, MessagesForm },
    setup() {
        const store = useStore();
        const router = useRouter();
        const toast = inject("$toast");
        const route = useRoute();
        const { t } = useI18n();
        const idSpace = route.params.id || route.query.id;
        const formData = reactive({
            term_of_use: "",
            cancellation_policy: "",
            prohibited_matter: "",
            faq: "",
            notices: "",
            note_from_space: "",
            questions_from_space: "",
            reservation_creation: "",
            reservation_after_payment: "",
            tomorrows_reminder: "",
        });
        const isCreated =
            store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_STEP_SPACE_CREATED}`] >
            STEP_CREATE_SPACE.PAGE_AND_EMAIL_MESSAGE;

        const errors = reactive({
            term_of_use: "",
            cancellation_policy: "",
        });
        const isPassValidate = computed(() => !Object.values(errors).some((item) => item));

        const validateTextForm = () => {
            const fieldsRequired = ["term_of_use", "cancellation_policy"];
            fieldsRequired.forEach((field) => {
                if (formData[field]) {
                    errors[field] = "";
                } else {
                    errors[field] = "必須項目です。 ";
                }
            });
        };

        const handleSubmit = async () => {
            validateTextForm();
            if (!isPassValidate.value) return;
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                await postSpacePageAndEmailMessage({ ...formData }, idSpace);
                if (!isCreated) {
                    store.commit(
                        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.MUTATIONS.SET_STEP_SPACE_CREATED}`,
                        STEP_SPACE_CREATED.approve
                    );
                }
                router.push(`${ROUTER_PATH.SPACE.APPROVAL}?id=${idSpace}`);
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };

        const handleBack = () => {
            router.push(`${ROUTER_PATH.SPACE.LIST_PLAN_INTERVAL}?id=${idSpace}`);
        };
        const getDetailSpaceGeneralFromApi = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getDetailSpaceGeneral(idSpace);
                if (res?.data) {
                    formData.term_of_use = res.data.general_space_information_terms_of_service;
                    formData.cancellation_policy = res.data.general_space_information_cancellation_policy;
                }
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            } finally {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
            }
        };
        const initData = async () => {
            getDetailSpaceGeneralFromApi();
            if (isCreated) {
                try {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                    const res = await Promise.all([getDetailSpaceEmailMessage(idSpace), getDetailSpacePage(idSpace)]);
                    const resWrapper = { ...res[0].data, ...res[1].data };
                    formData.term_of_use = resWrapper.term_of_use;
                    formData.cancellation_policy = resWrapper.cancellation_policy;
                    formData.prohibited_matter = resWrapper.prohibited_matter;
                    formData.faq = resWrapper.faq;
                    formData.notices = resWrapper.notices;
                    formData.note_from_space = resWrapper.note_from_space;
                    formData.questions_from_space = resWrapper.questions_from_space;
                    formData.reservation_creation = resWrapper.reservation_creation;
                    formData.reservation_after_payment = resWrapper.reservation_after_payment;
                    formData.tomorrows_reminder = resWrapper.tomorrows_reminder;
                } catch (errors) {
                    const error = errors.message || t("common.has_error");
                    toast.error(error);
                } finally {
                    store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
                }
            }
            store.dispatch(
                `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE}`,
                STEP_CREATE_SPACE.PAGE_AND_EMAIL_MESSAGE
            );
        };

        initData();
        return {
            optionsPageAndEmailMessage,
            JapanIcon,
            formData,
            handleSubmit,
            handleBack,
            errors,
        };
    },
};
</script>

<style scoped></style>
