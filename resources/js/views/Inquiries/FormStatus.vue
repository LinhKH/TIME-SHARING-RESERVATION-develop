<template>
  <div class="block m-2">
    <select
      v-model="selected"
      class="h-6 bg-white w-24 px-2 border border-solid border-[#dbdbdb] rounded-sm outline-none mb-1"
    >
      <option v-for="item in listStatus" :key="item.id" :value="item.id">
        {{ item.name }}
      </option>
    </select>
    <input
      type="text"
      name="manager"
      class="h-6 px-2 border border-solid mb-1 rounded border-[#4F4F4F]"
      v-model.trim="valueManager"
      placeholder="担当者"
    />
    <input
      type="text"
      name="correspondenceMemo"
      class="h-6 px-2 border border-solid mb-1 rounded border-[#4F4F4F]"
      v-model.trim="valueCorrespondence"
      placeholder="対応メモ"
    />
    <button
      class="bg-transparent hover:bg-green-500 text-green-700 font-semibold hover:text-white py-2 px-4 border border-green-500 hover:border-transparent rounded"
      href="#"
    >
      保存
    </button>
  </div>
</template>
<script>
import { ref } from "vue";
export default {
  setup(props, context) {
    const selected = ref(1);
    const valueManager = ref("");
    const valueCorrespondence = ref("");
    const listStatus = ref([
      {
        id: 1,
        name: "未対応",
      },
      {
        id: 2,
        name: "対応中",
      },
      {
        id: 3,
        name: "対応済み",
      },
    ]);
    return {
      selected,
      valueManager,
      valueCorrespondence,
      listStatus,
    };
  },
};
</script>
