<template>
  <li class="flex w-full relative itemLarge">
    <div
      @click="handleDatailLarge(treeData.id)"
      class="flex-1 flex items-center px-2 border-r border-solid border-[#ccc] text-[#337ab7] cursor-pointer hover:underline"
      :class="[treeData.parent_id ? 'pl-[25px]' : '']"
      :style="{ 'padding-left': level * 15 + 'px' }"
    >
      {{ treeData.title__ja || treeData.title__ja_kana }}
    </div>
    <div class="min-w-[120px] flex justify-center p-2">
      <button
        class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad] mr-[8px]"
      >
        <i class="fa fa-chevron-up"></i>
      </button>
      <button
        class="border border-solid border-[#ccc] py-[6px] px-[15px] rounded group text-[#fff] hover:bg-[#e6e6e6] hover:border-[#adadad]"
      >
        <i class="fa fa-chevron-down"></i>
      </button>
    </div>
  </li>
  <ul v-if="treeData.children && treeData.children.length">
    <NodeTree
      v-for="(child, indexChild) in treeData.children"
      :key="indexChild"
      :treeData="child"
      :level="level + 1"
    ></NodeTree>
  </ul>
</template>

<script>
import { useStore } from "vuex";
import { useI18n } from "vue-i18n";
import { ROUTER_PATH, MODULE_STORE, PAGE_DEFAULT, BOOLEAN } from "@/const";
import { useRouter, useRoute } from "vue-router";
import { ref, computed, watch, inject } from "vue";
export default {
  name: "NodeTree",
  props: {
    treeData: Object,
    level: Number,
  },
  setup({ props }) {
    const router = useRouter();
    const handleDatailLarge = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.LARGE_AREA_DETAIL}?id=${id}`);
    };
    return {
      handleDatailLarge,
    };
  },
};
</script>
<style scoped lang="scss">
.itemLarge::before {
  content: "";
  display: block;
  position: absolute;
  width: 100%;
  height: 1px;
  background-color: #ccc;
}
ul {
  margin: 0;
  min-width: 100%;
  li,
  ul {
    div {
      padding-left: 10px;
    }
  }
}
</style>
