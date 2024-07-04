<template>
    <rental-detail v-if="formData" :title="formData.title" :textareaDetail="formData.content"
        @submit="updatePageAndMessage" />
</template>

<script>
import RentalDetail from "@/components/RentalDetail";
import { MODULE_STORE, STEP_EDIT_SPACE, TYPE_MESSAGE_AND_PAGE } from "@/const";
import { useStore } from "vuex";
import { getDetailPageAndMessage, updateSpaceEmailMessage, updateSpacePage } from "@/api";
import { useI18n } from "vue-i18n";
import { useRoute } from "vue-router";
import { ref, inject } from "vue";
import { handleBack } from "@/utils";

export default {
    components: { RentalDetail },
    props: {
        isMessageManage: {
            type: Boolean,
            default: false,
        },
        isPageManage: {
            type: Boolean,
            default: false,
        },
    },
    setup(props) {
        const store = useStore();
        const { t } = useI18n();
        const route = useRoute();
        const formData = ref(null);
        const toast = inject("$toast");
        const idPageAndMessage = route.query.idPageAndMessage;
        let typePageAndMessage;
        const getDetailPageAndMessageFromApi = async () => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                const res = await getDetailPageAndMessage(idPageAndMessage, typePageAndMessage);
                formData.value = res;
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        const initData = () => {
            if (props.isMessageManage) {
                store.dispatch(
                    `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
                    STEP_EDIT_SPACE.INSERT_MESSAGE
                );
                typePageAndMessage = TYPE_MESSAGE_AND_PAGE.MESSAGE;
            }
            if (props.isPageManage) {
                store.dispatch(
                    `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
                    STEP_EDIT_SPACE.TERMS
                );
                typePageAndMessage = TYPE_MESSAGE_AND_PAGE.PAGE;
            }
            getDetailPageAndMessageFromApi();
        };
        const updatePageAndMessage = async (value) => {
            try {
                store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
                if (typePageAndMessage === TYPE_MESSAGE_AND_PAGE.PAGE) {
                    const param = {
                        page_content: value,
                        title: formData.value.title,
                    };
                    await updateSpacePage(idPageAndMessage, param);
                }
                if (typePageAndMessage === TYPE_MESSAGE_AND_PAGE.MESSAGE) {
                    await updateSpaceEmailMessage(idPageAndMessage, { email_content: value });
                }
                toast.success(t("toast_message.update_success"));
                handleBack();
            } catch (errors) {
                const error = errors.message || t("common.has_error");
                toast.error(error);
            }
            store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
        };
        initData();
        return { formData, updatePageAndMessage };
    },
};
</script>
<style></style>
