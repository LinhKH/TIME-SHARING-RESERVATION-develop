<template>
  <div class="mb-[10px] flex mt-2 items-center">
    <div class="w-64">
      <Label :label="label" :iconClass="iconClass" />
    </div>
    <div :class="isExtend ? 'flex-1' : 'w-[30%]'">
      <Input
        v-if="!isExtend && type == typeInput"
        :inputText="inputText"
        :inputKey="inputKey"
        @changeValue="updateValue"
        v-model="options"
      />
      <div class="flex" v-if="!isExtend && type == typeRadio">
        <div v-for="itemRadio in options" :key="itemRadio.id">
          <input
            class="cursor-pointer"
            type="radio"
            :id="itemRadio.id"
            :value="itemRadio.val"
            v-model="value"
            @click="changeValue(value)"
          />
          <label class="text-sm font-bold ml-1 mr-4 cursor-pointer" :for="itemRadio.id">{{ itemRadio.label }}</label>
        </div>
      </div>
      <slot v-if="isExtend"></slot>
    </div>
  </div>
</template>

<script>
import Label from "@/components/Label";
import Input from "@/components/Form/Input.vue";

export default {
  components: { Input, Label },
  props: {
    label: {
      type: String,
      default: "",
    },
    iconClass: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      default: "input",
    },
    dataForm: {
      type: Array,
      default: () => [],
    },
    options: {
      type: Array,
      default: () => [],
    },
    value: {
      type: String || Number,
    },
    isExtend: {
      type: Boolean,
      default: false,
    },
  },
  setup(props, { emit }) {
    const typeInput = "input";
    const typeRadio = "radio";
    const updateValue = (value) => {
      emit("change", value);
    };
    const changeValue = (value) => {
      emit("change", value);
    };
    return {
      updateValue,
      typeRadio,
      typeInput,
    };
  },
};
</script>

<style></style>
