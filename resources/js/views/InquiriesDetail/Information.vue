<template>
  <div class="information">
    <div class="flex h-10" v-for="item in information" :key="item.id">
      <div class="title w-1/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2 bg-[#ececec] font-bold">
        {{ item.name }}
      </div>
      <div class="value w-3/4 border border-[#dbdbdb] border-solid pt-2.5 pl-2">
        {{ item.name == "生年月日" ? getBirthday(item.value) : item.value }}
      </div>
    </div>
  </div>
</template>
<script>
import { convertDateNoTimeByTimestamp } from "@/utils";

export default {
  props: {
    information: { type: Array, default: [] },
  },
  setup(props, context) {
    const getBirthday = (timestamp) => {
      return timestamp ? convertDateNoTimeByTimestamp(timestamp) : "";
    };
    return {
      getBirthday,
    };
  },
};
</script>
<style></style>
