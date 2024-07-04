<template>
  <ListSettings
    v-if="listSettingsMessage"
    :list="listSettingsMessage"
    :path="ROUTER_PATH.SPACE.RENTAL_PLAN_DETAIL_MESSAGE"
  />
</template>

<script>
import { inject, ref } from "vue";
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { getRentalPlanMessageManage } from "@/api";
import ListSettings from "@/components/ListSettings";

export default {
  name: "RentalPlanMessageManage",
  components: { ListSettings },
  setup() {
    const store = useStore();
    const route = useRoute();
    const listSettingsMessage = ref();
    const toast = inject("$toast");
    const idSpace = route.params.id || route.query.id;
    const listInfoSettingMessage = [
      {
        icon: "fa fa-plus-circle",
      },
      { 
        icon: "fa fa-money",
      },
      {
        icon: "fa fa-star",
      },
      {
        icon: "fa fa-exclamation",
      },
    ];
    const getRentalPlanMessageManageFromApi = async () => {
      try {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const res = await getRentalPlanMessageManage(idSpace);
        listSettingsMessage.value = res.email_message_result.map((item, index) => ({
          ...item,
          info: listInfoSettingMessage[index],
        }));
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error); 
      } finally {
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };

    getRentalPlanMessageManageFromApi();
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.INSERT_MESSAGE
    );
    return { listSettingsMessage, listInfoSettingMessage, ROUTER_PATH };
  },
};
</script>

<style scoped></style>
