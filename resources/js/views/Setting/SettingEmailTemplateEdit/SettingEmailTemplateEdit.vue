<template>
  <FormSettingEmail :formData="formData" :error="error" :idEmailTemplate="idEmailTemplate" :formData1="formData1" />
  <div class="flex justify-center mt-5">
    <button class="p-2 bg-[#ffbd00] text-white outline-none rounded mr-5" @click="handleUpdateEmailTemplate">
      {{ $t("common.keep") }}
    </button>
    <button class="p-2 bg-[#d9534f] text-white outline-none rounded" @click="handleDeleteEmailTemplate">
      {{ $t("common.delete") }}
    </button>
  </div>
</template>

<script>
import FormSettingEmail from "@/components/Setting/FormSettingEmail";
import { reactive, inject } from "vue";
import { getDetailEmailTemplate, updateEmailTemplate, deleteEmailTemplate } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { MODULE_STORE } from "@/const";
import { useRoute } from "vue-router";
import { handleBack, isRequired } from "@/utils";

export default {
  name: "SettingEmailTemplateEdit",
  components: { FormSettingEmail },
  setup() {
    const toast = inject("$toast");
    const store = useStore();
    const route = useRoute();
    const { t } = useI18n();

    const idEmailTemplate = route.query.idEmailTemplate;
    const initForm = {
      email_type: "",
      content_jp: "",
      email_subject_jp: "",
    };

    const initForm1 = {
      email_subject_en: "",
      content_en: "",
      memo_en: "",
      memo_jp: "",
    };
    const formData = reactive({ ...initForm });

    const formData1 = reactive({ ...initForm1 });
    const error = reactive({ ...initForm });
    const handleUpdateEmailTemplate = async () => {
      if (!isRequired({ ...formData }, error)) {
        return;
      }
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await updateEmailTemplate(idEmailTemplate, { ...formData, ...formData1 });
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const handleDeleteEmailTemplate = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        await deleteEmailTemplate(idEmailTemplate);
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailEmailTemplate(idEmailTemplate);
        formData.email_type = res.data.email_type;
        formData1.email_subject_en = res.data.email_subject_en;
        formData.email_subject_jp = res.data.email_subject_jp;
        formData1.content_en = res.data.content_en;
        formData.content_jp = res.data.content_jp;
        formData1.memo_en = res.data.memo_en;
        formData1.memo_jp = res.data.memo_jp;
        toast.success("Success!");
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    initData();
    return {
      handleUpdateEmailTemplate,
      handleDeleteEmailTemplate,
      formData,
      error,
      idEmailTemplate,
      initForm1,
      formData1,
    };
  },
};
</script>

<style lang="scss" scoped></style>
