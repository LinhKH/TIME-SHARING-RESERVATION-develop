<template>
  <RentalPlan />
</template>

<script>
import RentalPlan from "@/components/Spaces/RentalPlan";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { inject } from "vue";
import { getDetailSpaceReservationSystem } from "@/api";
export default {
  name: "SpacePlanAddDraft",
  props: {
    maxPlan: {
      type: Number,
      default: () => 0,
    },
  },
  components: { RentalPlan },
  setup(props) {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    const idSpace = route.params.id || route.query.id;
    const getDetailSpaceReservationSystemFromApi = async () => {
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
      const res = await getDetailSpaceReservationSystem(idSpace);
      if (res?.length >= props.maxPlan) {
        router.back();
      }
      store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
    };
    getDetailSpaceReservationSystemFromApi();
  },
};
</script>

<style lang="scss" scoped></style>
