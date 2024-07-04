<template>
  <div class="flex items-center my-4">
    <div class="mr-20 w-32">
      <i class="fa fa-level-up"></i>
      <span class="font-bold">
        {{ title }}
      </span>
    </div>
    <ul class="multivalent__content" :key="keyUpdate">
      <li v-for="item in categories" :key="item.id">
        <label class="checkbox">
          <Checkbox :value="valueChecked" :id="item.id" @changeChecked="handleSelect" />
          <span class="block w-16">{{ item.name }}</span>
        </label>
      </li>
    </ul>
  </div>
</template>
<script>
import Checkbox from "./CheckboxBase.vue";
import { ref, computed, watch, inject } from "vue";
export default {
  name: "SelectionCategories",
  components: { Checkbox },
  props: {
    valueChecked: {
      type: Array,
      default: () => [],
    },
    categories: {
      type: Array,
    },
    title: { type: String, default: "" },
  },
  setup(props, context) {
    const keyUpdate = ref(0);
    watch(props.categories, () => {
      keyUpdate.value++;
    });
    const handleSelect = (id) => {
      let dataChange = [];
      if (props.valueChecked.includes(id)) dataChange = props.valueChecked.filter((item) => item !== id);
      else {
        dataChange = props.valueChecked;
        dataChange.push(id);
      }
      context.emit("handleChecked", dataChange);
    };
    return {
      keyUpdate,
      handleSelect,
    };
  },
};
</script>
<style lang="scss" scoped>
.multivalent__content {
  list-style: none;
  display: flex;
  li {
    margin-right: 12px;
    .checkbox {
      display: flex;
      span {
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        font-weight: 700;
      }
    }
  }
}
</style>
