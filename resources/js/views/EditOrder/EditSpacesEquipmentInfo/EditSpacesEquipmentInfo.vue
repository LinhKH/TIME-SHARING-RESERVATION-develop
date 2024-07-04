<template>
  <EquipmentInformation v-if="dataFill" :actionType="ACTIONS_TYPE.UPDATE" :dataFill="dataFill" />
</template>

<script>
import EquipmentInformation from "@/components/Spaces/EquipmentInformation";
import { ACTIONS_TYPE, STEP_EDIT_SPACE, MODULE_STORE } from "@/const";
import { useStore } from "vuex";
import { getDetailSpaceEquipmentInfo } from "@/api";
import { inject, ref } from "vue";
import { useRoute } from "vue-router";
import { useI18n } from "vue-i18n";

export default {
  name: "EditSpacesEquipmentInfo",
  components: { EquipmentInformation },
  setup() {
    const store = useStore();
    const route = useRoute();
    const dataFill = ref();
    const { t } = useI18n();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const initData = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSpaceEquipmentInfo(idSpace);
        dataFill.value = res.data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    initData();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.EQUIPMENT_INFORMATION
    );
    return {
      ACTIONS_TYPE,
      dataFill,
    };
  },
};
</script>

<style scoped></style>