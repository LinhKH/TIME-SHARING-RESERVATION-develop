<template>
  <EditEquipmentInfo />
</template>

<script>
import EditEquipmentInfo from "./child/EditEquipmentInfo.vue";
import { ACTIONS_TYPE, STEP_EDIT_SPACE, MODULE_STORE } from "@/const";

import { useStore } from "vuex";
export default {
  name: "EditTransport",
  components: { EditEquipmentInfo },
  setup() {
    const store = useStore();

    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.TRANSPORTATION_FACILITIES
    );
    return {};
  },
};
</script>

<style></style>
