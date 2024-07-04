<template>
  <div class="p-[10px]">
    <div class="p-[15px] leading-8">
      <i class="fa fa-lightbulb-o font-bold"></i>
      <span class="text-[12px] font-bold">{{ $t("holiday_import.header") }}</span>
    </div>
    <div class="mb-[5px] flex">
      <label class="w-[20%] font-bold">{{ $t("holiday_import.label") }}</label>
      <div>
        <input type="file" accept=".csv" @change="handleImportFile" />
        <div class="m-[10px]">{{ $t("holiday_import.sub_label") }}</div>
      </div>
    </div>
    <div class="flex justify-center mt-3">
      <ButtonGeneral :text="$t('holiday_import.text_button')" :icon="`text-white`" @clickButton="handleClickImport" />
    </div>
  </div>
  <div>{{ $t("holiday_import.page") }}</div>
</template>

<script>
import { useI18n } from "vue-i18n";
import ButtonGeneral from "@/components/Buttons/ButtonGeneral";
import { importCSVHolidaySetting } from "@/api";
import { inject, ref } from "vue";
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";
import { handleBack } from "@/utils";

export default {
  name: "HolidayImport",
  components: { ButtonGeneral },
  setup() {
    const { t } = useI18n();
    const file = ref();
    const store = useStore();
    const toast = inject("$toast");

    const handleImportFile = (event) => {
      file.value = event.target.files[0] || "";
    };

    const handleClickImport = async () => {
      try {
        if (!file.value) {
          return;
        }
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const formData = new FormData();
        formData.append("file", file.value);
        await importCSVHolidaySetting(formData);
        handleBack();
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    return { handleClickImport, handleImportFile };
  },
};
</script>

<style></style>
