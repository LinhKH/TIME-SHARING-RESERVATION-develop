<template>
  <div class="nav-function">
    <ul class="flex justify-start align-center">
      <li class="nav-function__item" v-for="(navItem, index) in navFunctionList" :key="index">
        <a href="" class="text-base block py-4 px-2.5 hover:bg-[#eee] hover:rounded-t transition-all">
          <i :class="navItem.icon" class="text-[#7f8084] text-[32px]"></i>
          <span class="text-[#7f8084]">{{ navItem.title }}</span>
        </a>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  name: "NavFunctionTour",
  props: {
    navFunctionList: {
      type: Array,
      defaul: () => [],
    },
  },
};
</script>
<style></style>
