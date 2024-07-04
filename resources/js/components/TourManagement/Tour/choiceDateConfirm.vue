<template>
  <div>
    <label
      v-for="(item, index) in Object.keys(listOptions)"
      :key="index"
      class="mt-1.5 rounded font-medium inline-block flex items-center"
    >
      <span v-if="item == checkDate" class="text-[13px] font-semibold"> {{ option[item] }}</span>
      <span v-else class="text-[#ccc] text-[14px] line-through"> {{ option[item] }}</span>
    </label>
  </div>
</template>
<script>
import { ref, computed } from "vue";
export default {
  name: "ChoiceDateConfirm",
  props: {
    option: Object,
    checkDate: String,
  },
  setup(props) {
    const listOptions = ref({
      first_choice_date: props.option?.first_choice_date,
      second_choice_date: props.option?.second_choice_date,
      third_choice_date: props.option?.third_choice_date,
    });
    const tourDate = computed(() => {
      if (props.option?.tour_date) {
        return props.option[props.option.tour_date];
      }
      return null;
    });

    return { listOptions, tourDate };
  },
};
</script>
<style></style>
