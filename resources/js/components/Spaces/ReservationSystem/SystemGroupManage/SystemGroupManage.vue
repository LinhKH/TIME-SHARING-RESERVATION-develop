<template>
  <div v-if="!isLoading">
    <button class="bg-[#ffbd00] p-2 rounded my-2" @click="gotoAddGroup">
      <div>
        <i class="fa fa-plus mr-1 text-white"></i>
        <span class="text-white">{{ $t("system_group_manage.add_new_plan_group") }}</span>
      </div>
      <div class="text-white text-[10px] mt-1">{{ $t("system_group_manage.plan_linked") }}</div>
    </button>
    <div
      class="w-full h-14 rounded border border-solid border-[#d6e9c6] bg-[#dff0d8] flex items-center px-2"
      v-if="!listGroup.length"
    >
      <span class="fa-stack fa-lg">
        <i class="fa fa-circle-thin fa-stack-2x text-[#3c763d]"></i>
        <i class="fa-stack-1x fa fa-check text-[#3c763d]"></i>
      </span>
      <span class="text-[#3c763d]">
        {{ $t("system_group_manage.welcome_to_our_online") }}
      </span>
    </div>
    <template v-if="listGroup.length">
      <div v-for="(item, index) in listGroup" :key="index">
        <BoxGroup :detailGroup="item"></BoxGroup>
      </div>
    </template>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { MODULE_STORE, STEP_EDIT_SPACE, ROUTER_PATH } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { getListGroup } from "@/api";
import { inject, ref } from "vue";
import { useI18n } from "vue-i18n";
import BoxGroup from "./child/BoxGroup.vue";

export default {
  name: "SystemGroupManage",
  components: { BoxGroup },
  setup() {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    const toast = inject("$toast");
    const { t } = useI18n();
    const listGroup = ref([]);
    const isLoading = ref(false);
    const idSpace = route.params.id || route.query.id;
    store.dispatch(
      `${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.ACTIONS.SET_ACTIVE_EDIT}`,
      STEP_EDIT_SPACE.RESERVATION_SYSTEM
    );
    const gotoAddGroup = () => {
      router.push(
        `${ROUTER_PATH.ADMIN}/${ROUTER_PATH.ORDER}/${ROUTER_PATH.RENTAL_PLAN}/${ROUTER_PATH.SPACE.GROUP_ADD}/${idSpace}`
      );
    };
    const initData = async () => {
      try {
        isLoading.value = true;
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = true;
        const data = await getListGroup(idSpace);
        listGroup.value = data;
      } catch (errors) {
        const error = errors.message || t("common.has_error");
        toast.error(error);
      } finally {
        isLoading.value = false;
        store.state[MODULE_STORE.COMMON.NAME].isLoadingPage = false;
      }
    };
    initData();
    return { isLoading, gotoAddGroup, listGroup };
  },
};
</script>

<style scoped></style>