<template>
  <FormSettingEmail :formData="formData" :error="error" :formData1="formData1" />
  <button
    class="p-2 bg-[#ffbd00] text-white outline-none rounded block mx-auto mt-2"
    @click="handleCreateEmailTemplate"
  >
    {{ $t("common.keep") }}
  </button>
</template>

<script>
import FormSettingEmail from "@/components/Setting/FormSettingEmail";
import { reactive, inject } from "vue";
import { createEmailTemplate } from "@/api";
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { MODULE_STORE } from "@/const";
import { handleBack, isRequired } from "@/utils";

export default {
  name: "SettingEmailTemplateAdd",
  components: { FormSettingEmail },
  setup() {
    const { t } = useI18n();
    const toast = inject("$toast");
    const store = useStore();
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
    const handleCreateEmailTemplate = async () => {
      if (!isRequired({ ...formData }, error)) {
        return;
      }

      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;

        await createEmailTemplate({ ...formData, ...formData1 });
        toast.success("Success!");
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    return { formData, formData1, handleCreateEmailTemplate, error };
  },
};
</script>
