<template>
  <div v-if="option.status === 'waiting_response_user' || option.status === 'fix_date_time'" class="min-w-[200px]">
    <div v-for="(item, index) in Object.keys(listOptions)" :key="index">
      <div>
        <label
          v-if="option.fix_choice_date_column_name === item"
          class="hover:bg-[#67a3e9] mt-1.5 border border-solid border-[#ccc] p-1.5 rounded font-medium inline-block cursor-pointer flex items-center"
        >
          <input type="radio" name="choice_date" class="mr-1" :value="item" @input="$emit('changeChoiceDate', item)" />
          <span>{{ option[item] }}</span>
        </label>
        <label
          v-if="option.fix_choice_date_column_name !== item"
          class="mt-1.5 rounded font-medium inline-block flex items-center"
        >
          <span class="text-[#ccc] text-[14px] font-bold line-through"> {{ option[item] }}</span>
        </label>
      </div>
    </div>
  </div>

  <div v-if="option.status === 'pending_request'" class="min-w-[200px]">
    <div v-for="(item, index) in Object.keys(listOptions)" :key="index">
      <label
        v-if="option[item]"
        class="hover:bg-[#67a3e9] mt-1.5 border border-solid border-[#ccc] p-1.5 rounded font-medium inline-block cursor-pointer flex items-center"
      >
        <input type="radio" name="choice_date" class="mr-1" :value="item" @input="confirmChoiceDate(item)" />
        <span>{{ option[item] }}</span>
      </label>
    </div>
  </div>

  <div
    v-if="option.status === 'change_date_time' || option.status === 'user_cancel' || option.status === 'observation_NG'"
    class="min-w-[200px]"
  >
    <label
      v-for="(item, index) in Object.keys(listOptions)"
      :key="index"
      class="mt-1.5 rounded font-medium inline-block flex items-center"
    >
      <span class="text-[#ccc] text-[14px] font-bold line-through"> {{ option[item] }}</span>
    </label>
  </div>

  <!-- <div v-if="option.status === 'observation_NG'" class="min-w-[200px]">
    <label
      v-for="(item, index) in Object.keys(listOptions)"
      :key="index"
      class="mt-1.5 rounded font-medium inline-block flex items-center"
    >
      <span class="text-[#ccc] text-[14px] font-bold line-through"> {{ option[item] }}</span>
    </label>
    <div v-for="(item, index) in Object.keys(listSubOptions)" :key="index">
      <label
        v-if="option[item]"
        class="hover:bg-[#67a3e9] mt-1.5 border border-solid border-[#ccc] p-1.5 rounded font-medium inline-block cursor-pointer flex items-center"
      >
        <input type="radio" name="choice_date" class="mr-1" :value="item" @input="$emit('changeChoiceDate', item)" />
        <span>{{ option[item] }}</span>
      </label>
    </div>
  </div> -->
</template>
<script>
import { ref, computed, watch } from "vue";
export default {
  name: "ChoiceDate",
  props: {
    isPreview: {
      type: Boolean,
      default: false,
    },
    isPreviewAlternative: {
      type: Boolean,
      default: false,
    },
    option: Object,
  },

  setup(props, { emit }) {
    const choiceDate = ref();
    const listOptions = ref({
      first_choice_date: props.option?.first_choice_date,
      second_choice_date: props.option?.second_choice_date,
      third_choice_date: props.option?.third_choice_date,
    });
    const listSubOptions = ref({
      substitute_first_choice_date: props.option?.substitute_first_choice_date,
      substitute_second_choice_date: props.option?.substitute_second_choice_date,
      substitute_third_choice_date: props.option?.substitute_third_choice_date,
    });
    const tourDate = computed(() => {
      if (props.option?.tour_date) {
        return props.option[props.option.tour_date];
      }
      return null;
    });
    const confirmChoiceDate = (date) => {
      emit("confirmChoiceDate", date, props.option?.id);
    };

    return { listOptions, tourDate, listSubOptions, confirmChoiceDate, choiceDate };
  },
};
</script>
<style></style>
