<template>
  <div class="p-2">
    <RentalPlan :isAddScreen="false" :preview="true" :actionType="ACTIONS_TYPE.UPDATE" />
  </div>
</template>

<script>
import RentalPlan from "@/components/Spaces/RentalPlan";
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE, ACTIONS_TYPE } from "@/const";
export default {
  name: "SpacePlanEdit",
  components: { RentalPlan },
  setup() {
    const store = useStore();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.RESERVATION_SYSTEM
    );
    return { ACTIONS_TYPE };
  },
};
</script>

<style scoped></style>
