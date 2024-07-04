<template>
  <div class="flex flex-wrap mx-auto">
    <div
      class="cursor-pointer p-2 min-w-[75px] border-b border-solid border-[#ddd] hover:bg-[#eee] transition-all duration-200"
      :class="item.isActive && 'border-b-2 border-[red]'"
      v-for="(item, index) in listMenuEdit"
      :key="index"
      @click="() => handleChangeStep(item)"
    >
      <i :class="item.icon" class="mr-1"></i>
      <span>{{ item.name }}</span>
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { MODULE_STORE } from "@/const";
import { useRouter, useRoute } from "vue-router";

export default {
  name: "StepDetailOrder",
  components: {},
  setup() {
    const store = useStore();
    const router = useRouter();
    const route = useRoute();
    const listMenuEdit =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_LIST_STEP_EDIT}`];
    const idEditSpace =
      store.getters[`${MODULE_STORE.RENTAL_SPACES.NAME}/${MODULE_STORE.RENTAL_SPACES.GETTERS.GET_ID_EDIT_SPACE}`] ||
      route.params.id ||
      route.query.id;
    const handleChangeStep = (item) => {
      router.push(`${item.link}/${idEditSpace}`);
    };

    return { listMenuEdit, handleChangeStep };
  },
};
</script>

<style scoped></style>
