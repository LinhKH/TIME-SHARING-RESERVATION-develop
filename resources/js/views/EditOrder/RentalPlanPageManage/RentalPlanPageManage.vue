<template>
  <ListSettings v-if="listSettingsPage" :list="listSettingsPage" :path="ROUTER_PATH.SPACE.RENTAL_PLAN_DETAIL_PAGE" />
</template>

<script>
import { inject, ref } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { getRentalPlanPageManage } from "@/api";
import ListSettings from "@/components/ListSettings";

export default {
  name: "RentalPlanPageManage",
  components: { ListSettings },
  setup() {
    const store = useStore();
    const route = useRoute();
    const listSettingsPage = ref();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const listInfoSettingPage = [
      {
        icon: "fa fa-check",
      },
      {
        icon: "fa fa-ban",
      },
      {
        icon: "fa fa-times",
      },
      {
        icon: "fa fa-question-circle",
      },
      {
        icon: "fa fa-newspaper-o",
      },
      {
        icon: "fa fa-list-ul",
      },
      {
        icon: "fa fa-question-circle",
      },
    ];
    const getRentalPlanPageManageFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getRentalPlanPageManage(idSpace);
        listSettingsPage.value = res.pages.map((item, index) => ({
          ...item,
          info: listInfoSettingPage[index],
        }));
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    getRentalPlanPageManageFromApi();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.TERMS
    );
    return { listSettingsPage, ROUTER_PATH };
  },
};
</script>

<style scoped></style>
