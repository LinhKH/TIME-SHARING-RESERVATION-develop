<template>
  <div class="border border-solid border-[#ccc] w-full">
    <div class="flex">
      <div class="" v-for="(largeHeaderItem, index) in LargeAreaHeader" :key="index" :class="largeHeaderItem.with">
        {{ largeHeaderItem.label }}
      </div>
    </div>
  </div>
  <ul class="listLarge border border-solid border-[#ccc]">
    <NodeTree :treeData="largeItem" v-for="(largeItem, index) in treeData" :key="index" :level="1" />
  </ul>
</template>

<script>
import { useI18n } from "vue-i18n";
import NodeTree from "./NodeTree";

export default {
  props: {
    treeData: Object,
  },
  components: {
    NodeTree,
  },
  setup() {
    const { t } = useI18n();
    const LargeAreaHeader = [
      { with: "p-2 flex-1 border-r border-solid border-[#ccc]", label: t("large_area.large_area") },
      { with: "p-2 min-w-[120px]", label: t("") },
    ];
    return { LargeAreaHeader };
  },
};
</script>

<style>
/* .listLarge ul {
  padding-left: 16px;
} */
</style>
