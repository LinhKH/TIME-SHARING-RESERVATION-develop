<template>
  <ReservationOptions :isEditScreen="true" />
  <LayoutInput :labelText="$t('system_reservation_option.set_enrolled')" customCss="mt-5">
    <div class="flex flex-wrap">
      <div
        class="text-[#337ab7] cursor-pointer hover:underline mr-2"
        v-for="(item, index) in listSpace"
        :key="index"
        @click="() => handleEditPlan(item)"
      >
        {{ item.plan_name }}
      </div>
    </div>
  </LayoutInput>
</template>

<script>
import ReservationOptions from "@/components/Spaces/ReservationOptions";
import { useStore } from "vuex";
import { MODULE_STORE, ROUTER_PATH, STEP_EDIT_SPACE } from "@/const";
import LayoutInput from "@/components/Layouts/LayoutInput.vue";
import { getListPlan } from "@/api";
import { useRoute, useRouter } from "vue-router";
import { ref, inject } from "vue";
import { useI18n } from "vue-i18n";

export default {
  name: "SystemReservationOption",
  components: { ReservationOptions, LayoutInput },
  setup() {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const { t } = useI18n();
    const listSpace = ref([]);
    const initData = async () => {
      store.dispatch(
        `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
        STEP_EDIT_SPACE.RESERVATION_SYSTEM
      );
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getListPlan(idSpace);
        listSpace.value = res?.rentalPlan;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    const handleEditPlan = (planDetail) => {
      const idPlan = planDetail.id;
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.PLAN_EDIT}/${idSpace}?idPlan=${idPlan}`
      );
    };
    initData();
    return { listSpace, handleEditPlan };
  },
};
</script>

<style scoped></style>
