<template>
  <div class="flex border-b border-solid border-[#ddd]">
    <button
      class="p-3 bg-white"
      :class="
        isScreen === itemMenu.type &&
        'border-t border-r border-l rounded-tl rounded-tr border-solid border-[#ddd] mb-[-1px]'
      "
      v-for="(itemMenu, indexMenu) in listMenus"
      :key="indexMenu"
      @click="$emit('onChangeTab', itemMenu.type)"
    >
      <i class="mr-1" :class="[itemMenu.icon, isScreen === itemMenu.type ? 'text-[#555]' : 'text-[#337ab7]']"></i>
      <span :class="isScreen === itemMenu.type ? 'text-[#555]' : 'text-[#337ab7]'">{{ itemMenu.text }}</span>
    </button>
  </div>
</template>

<script>
export default {
  name: "Menu",
  props: {
    listMenus: Array,
    isScreen: String,
  },
  emits: ["onChangeTab"],
};
</script>

<style lang="scss" scoped></style>
