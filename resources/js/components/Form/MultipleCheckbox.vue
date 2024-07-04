<template>
  <div v-if="Object.keys(optionFilterReservation).length" class="grid grid-cols-4 gap-y-2 gap-x-1">
    <label class="flex font-bold" v-for="(item, index) in Object.keys(optionFilterReservation)" :key="index">
      <input type="checkbox" class="mr-2" v-model="listSelected" :value="item" />
      {{ optionFilterReservation[item] }}
    </label>
  </div>
  <div class="flex mt-5" v-if="!hiddenButton">
    <ButtonCommon :text="`全解除`" class="py-2 min-w-[110px]" @click="handleReleaseAll" />
    <ButtonCommon :text="`全選択`" class="py-2 min-w-[110px]" @click="handleSelectAll" />
  </div>
</template>

<script>
import { ref, watch } from "vue";
import ButtonCommon from "@/components/Buttons/ButtonCommon";

export default {
  name: "MultipleCheckbox",
  props: {
    optionFilterReservation: Object,
    hiddenButton: { type: Boolean, default: false },
    valueSelected: Object,
  },
  emits: ["onInput"],
  components: { ButtonCommon },
  setup(props, context) {
    const listSelected = ref([]);
    watch(
      () => props.valueSelected,
      (value) => {
        if (value) {
          listSelected.value = value;
        }
      },
      { immediate: true }
    );
    const handleSelectAll = () => {
      const listSelectAll = Object.keys(props.optionFilterReservation).map((item) => item);
      listSelected.value = listSelectAll;
    };
    const handleReleaseAll = () => (listSelected.value = []);
    watch(listSelected, (value) => {
      context.emit("onInput", value);
    });
    return { listSelected, handleReleaseAll, handleSelectAll };
  },
};
</script>

<style lang="scss" scoped></style>
