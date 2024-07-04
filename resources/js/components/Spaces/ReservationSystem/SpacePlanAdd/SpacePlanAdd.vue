<template>
  <RentalPlan :isAddScreen="false" />
</template>

<script>
import RentalPlan from "@/components/Spaces/RentalPlan";
import { useStore } from "vuex";
import { useRouter, useRoute } from "vue-router";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { inject } from "vue";
import { getDetailSpaceReservationSystem } from "@/api";
export default {
  name: "SpacePlanAdd",
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
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.RESERVATION_SYSTEM
    );
    const getDetailSpaceReservationSystemFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSpaceReservationSystem(idSpace);
        if (res?.length >= props.maxPlan) {
          router.back();
        }
      } catch (error) {
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getDetailSpaceReservationSystemFromApi();
  },
};
</script>

<style lang="scss" scoped></style>
