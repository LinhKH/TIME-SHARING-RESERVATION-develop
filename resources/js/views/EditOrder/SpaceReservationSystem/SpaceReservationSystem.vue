<template>
  <div>
    <SideBarSwitchView :idSpace="idSpace" :canAddMore="canAddMore" />
    <div>
      <div
        v-for="(item, index) in dataTable"
        class="border-l border-r first:border-t"
        :class="item.rental_plan_status === 'active' ? 'border-[#37a200]' : 'border-[#555555]'"
        :key="index"
      >
        <ReservationSystem :dataTableItem="item" @resetData="handleGetDetail" />
      </div>
    </div>
  </div>
</template>

<script>
import { ACTIONS_TYPE, STEP_EDIT_SPACE, MODULE_STORE } from "@/const";
import { useStore } from "vuex";
import { getDetailSpaceReservationSystem } from "@/api";
import { inject, ref } from "vue";
import { useRoute } from "vue-router";
import ReservationSystem from "@/components/Spaces/ReservationSystem/ReservationSystem.vue";
import SideBarSwitchView from "./child/SideBarSwitchView.vue";

export default {
  name: "SpaceReservationSystem",
  props: {
    maxPlan: {
      type: Number,
      default: () => 0,
    },
  },
  setup(props) {
    const store = useStore();
    const route = useRoute();
    const canAddMore = ref(true);
    let dataTable = ref();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const idPlan = ref(null);
    const getDetailSpaceReservationSystemFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getDetailSpaceReservationSystem(idSpace);
        dataTable.value = res;
        canAddMore.value = dataTable.value.length < props.maxPlan;
      } catch (error) {
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const initData = async () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
        STEP_EDIT_SPACE.RESERVATION_SYSTEM
      );
      getDetailSpaceReservationSystemFromApi();
    };
    const handleGetDetail = () => {
      getDetailSpaceReservationSystemFromApi();
      window.scroll({ top: 0 });
    };
    initData();
    return {
      ACTIONS_TYPE,
      dataTable,
      idSpace,
      idPlan,
      handleGetDetail,
      canAddMore,
    };
  },
  components: { ReservationSystem, SideBarSwitchView },
};
</script>

<style scoped></style>
