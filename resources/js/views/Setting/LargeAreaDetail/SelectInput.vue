<template>
  <div>
    <div
      class="w-full border border-solid border-[#ddd] rounded flex justify-start items-center h-8"
      @click="toggleListOption"
    >
      <input
        type="text"
        class="w-full py-[5px] px-[8px] outline-none rounded"
        v-model="parentTitle"
        @input="checkChangeValue($event)"
      />
      <i
        v-if="isShowIcon === false"
        class="fa fa-chevron-down text-[13px] py-[5px] px-[8px] cursor-pointer text-[#ddd] transition-colors"
      ></i>
      <i
        v-if="isShowIcon === true"
        class="fa fa-search text-[13px] py-[5px] px-[8px] cursor-pointer text-[#ddd] transition-colors"
      ></i>
    </div>
    <span></span>
    <div
      v-if="isListOption"
      class="border border-solid border-[#ddd] w-full mt-[1px] rounded transition-all top-[99%] bg-[#fff] absolute top-[100%] bg-[#fff] z-10"
    >
      <div
        v-if="filteredUser.length === 0"
        class="p-[8px] list-none border-b border-b-solid border-b-[#ddd] last:border-b-0 transition-all"
      >
        No Data Available
      </div>
      <li
        v-for="(options, index) in filteredUser"
        :key="index"
        @click="selectItem(options)"
        class="p-[8px] list-none border-b border-b-solid border-b-[#ddd] last:border-b-0 cursor-pointer hover:bg-[#e5cce1] transition-all"
      >
        {{ options.title__ja || options.title__ja_kana }}
      </li>
    </div>
  </div>
</template>
<script>
import { computed, ref, watch, onMounted } from "vue";

export default {
  name: "SelectInput",
  props: {
    listOption: {
      type: Object,
      default: () => {},
    },
    parentTitle: { type: String, default: () => 0 },
  },
  setup(props, { emit }) {
    const isShowIcon = ref(false);
    const valueInput = ref("");
    const isListOption = ref(false);
    const selectedItem = ref(null);
    const isVisible = ref(false);
    const useArray = ref([]);
    const toggleListOption = () => {
      isShowIcon.value = !isShowIcon.value;
      isListOption.value = !isListOption.value;
    };
    const checkChangeValue = (event) => {
      isListOption.value = true;
      emit("handleValueInput", event.target.value);
    };
    const filteredUser = computed(() => {
      let query;
      if (props.parentTitle) {
        query = props.parentTitle.toLowerCase();
      } else {
        query = props.parentTitle;
      }

      if (props.parentTitle === "") {
        return useArray.value;
      }
      return useArray.value.filter((user) => {
        return Object.values(user).some((word) => String(word).toLowerCase().includes(query));
      });
    });
    onMounted(() => {
      useArray.value = props.listOption;
    });
    const selectItem = (options) => {
      isListOption.value = false;
      emit("getParentId", options);
    };

    return {
      isShowIcon,
      toggleListOption,
      valueInput,
      checkChangeValue,
      selectedItem,
      isVisible,
      useArray,
      filteredUser,
      isListOption,
      selectItem,
    };
  },
};
</script>

<style></style>
