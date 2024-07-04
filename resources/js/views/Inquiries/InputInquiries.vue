<template>
  <div class="form-input flex items-center my-2" :class="listField.readonly ? 'input-readonly' : ''">
    <div class="mr-20 w-32">
      <i :class="listField.icon"></i>
      <span class="font-bold">
        {{ title }}
      </span>
    </div>
    <input
      :type="listField.type"
      :name="listField.name"
      class="input border-color bg-white w-96 h-8 px-2 border border-solid border-[#dbdbdb] rounded outline-none focus:shadow-lg focus:shadow-cyan-500/50 focus:border-cyan-500/50"
      :class="listField.class"
      v-model.trim="textValue"
      :readonly="listField.readonly"
      :placeholder="listField.placeholder"
    />
    <span class="delete-text"><i class="fa fa-times" aria-hidden="true"></i></span>
  </div>
</template>

<script>
import { ref, computed, watch, inject } from "vue";
export default {
  props: {
    title: { type: String, default: "" },
    listField: { type: Array, default: [] },
  },
  setup(props, context) {
    const textValue = ref("");
    watch(textValue, (val) => {
      context.emit("clickInput", val);
    });
    return {
      textValue,
    };
  },
};
</script>
<style lang="scss" scoped>
.form-input {
  @media (max-width: 1200px) {
    display: block;
    input {
      width: 97%;
    }
  }
  .delete-text {
    padding: 8px 12px;
    font-size: 14px;
    font-weight: 400;
    line-height: 1;
    color: #555;
    text-align: center;
    background-color: #eee;
    border: 1px solid #ccc;
    border-radius: 0 4px 4px 0;
    margin-left: -16px;
    i {
      color: #555;
      font-size: 14px;
    }
  }
  .input-readonly {
    input {
      background-color: #eee;
    }
  }
}
</style>
