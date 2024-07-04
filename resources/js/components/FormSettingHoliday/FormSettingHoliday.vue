<template>
  <div class="flex justify-end">
    <ButtonGeneral :text="$t('setting_holiday.text_button')" :icon="`fa fa-upload text-white`" @click="goToImport" />
  </div>
  <div class="flex">
    <button
      @click="() => setCurrentYear(ACTIONS_TYPE.ALL)"
      class="p-[5px] m-[5px] border border-[#ccc] rounded text-[#337ab7] hover:bg-gray-200"
      :class="[currentYear == ACTIONS_TYPE.ALL ? 'bg-[#337ab7] text-[#fff]' : '']"
    >
      全て
    </button>
    <button
      v-for="(item, index) in Object.keys(dataForm)"
      :key="index"
      @click="() => setCurrentYear(item)"
      class="p-[5px] m-[5px] border border-[#ccc] rounded text-[#337ab7] hover:bg-gray-200"
      :class="[currentYear == item ? 'bg-[#337ab7] text-[#fff]' : '']"
    >
      {{ item }}
    </button>
  </div>
  <FormHolidayTable :dataTableHeader="dataTableHeader" :dataTable="dataFormTable" />
</template>
<script>
import { useI18n } from "vue-i18n";
import { ref, inject, watch } from "vue";
import ButtonGeneral from "@/components/Buttons/ButtonGeneral";
import FormHolidayTable from "@/components/FormSettingHoliday/FormHolidayTable";
import { ROUTER_PATH, MODULE_STORE, ACTIONS_TYPE } from "@/const";
import { useRouter } from "vue-router";
import { getListHoliday } from "@/api";
import { useStore } from "vuex";

export default {
  name: "FormSettingHoliday",
  components: { ButtonGeneral, FormHolidayTable },
  setup() {
    const { t } = useI18n();
    const currentYear = ref();
    const router = useRouter();
    const toast = inject("$toast");
    const dataForm = ref({});
    const store = useStore();
    const dataFormTable = ref({});

    const dataTableHeader = [
      {
        text: t("setting_holiday.year"),
        width: "10%",
      },
      {
        text: t("setting_holiday.month"),
        width: "5%",
      },
      {
        text: t("setting_holiday.day"),
        width: "5%",
      },
      {
        text: t("setting_holiday.holiday"),
        width: "70%",
      },
    ];
    watch(
      currentYear,
      () => {
        if (currentYear.value == ACTIONS_TYPE.ALL) {
          dataFormTable.value = Object.keys(dataForm.value)
            .map((item) => dataForm.value[item])
            .flat(Infinity);
          return;
        }
        dataFormTable.value = dataForm.value[currentYear.value];
      },
      { immediate: true }
    );
    const goToImport = () => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.HOLIDAY_IMPORT}`);
    };
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListHoliday();
        dataForm.value = { ...dataForm.value, ...res };
        currentYear.value = Math.max(...Object.keys(res).map((item) => item));
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    const setCurrentYear = (year) => {
      currentYear.value = year;
    };
    initData();

    return { dataForm, dataTableHeader, goToImport, currentYear, ACTIONS_TYPE, setCurrentYear, dataFormTable };
  },
};
</script>

<style></style>
