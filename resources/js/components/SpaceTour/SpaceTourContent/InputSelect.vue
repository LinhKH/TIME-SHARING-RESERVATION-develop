<template>
  <div class="flex items-center justify-around text-[16px] mb-[15px]">
    <div class="w-[25%] flex justify-star items-center flex-wrap">
      <span class="text-[#626262] leading-[25px] mr-[5px]">{{ visitItem.title }}</span>
      <span v-if="visitItem.required" class="text-white bg-red-400 py-1 px-3 rounded text-[14px]">{{
        $t("space_tour.required")
      }}</span>
    </div>
    <div class="w-[75%] flex justify-start items-center text-[14px]">
      <Field
        name="field"
        as="select"
        class="w-[50%] py-2 px-2.5 rounded mr-[4px] border border-solid border-[#ccc] focus:outline-none focus:border-sky-500 shadow focus:shadow-[ inset_0_1px_1px_rgb(0 0 0 / 8%), 0_0_8px_rgb(102 175 233 / 60%)] bg-white"
      >
        <option value="" disabled>{{ visitItem.placeholder }}</option>
        <option v-for="(itemChildVisit, index) in visitItem.children" :key="index" :value="visitItem.title">
          {{ itemChildVisit.title }}
        </option>
      </Field>
    </div>
  </div>
</template>
<script>
import { Field } from "vee-validate";
export default {
  name: "InputSelect",
  components: {
    Field,
  },
  props: {
    visitItem: {
      type: Object,
      default: () => {},
    },
  },
  setup(props, { emit }) {
    return {};
  },
};
</script>
<style></style>
