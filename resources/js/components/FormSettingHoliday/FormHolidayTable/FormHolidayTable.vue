<template>
  <div>
    <table class="w-full border-collapse mt-2">
      <thead>
        <tr class="even:bg-gray-100">
          <th
            v-for="(item, index) in headerTable"
            :key="index"
            class="border border-solid border-[#ddd] p-[8px] text-left font-bold"
            :class="item.classWidth"
          >
            {{ item.text }}
          </th>
        </tr>
      </thead>
      <tbody>
        <template v-if="dataTable.length">
          <tr v-for="(item, index) in dataTable" :key="index" class="even:bg-gray-100">
            <td class="p-[8px] border border-solid border-[#ddd] font-bold">
              {{ item.year }}
            </td>
            <td class="p-[8px] border border-solid border-[#ddd] font-bold">
              {{ item.month }}
            </td>
            <td class="p-[8px] border border-solid border-[#ddd] font-bold">
              {{ item.day }}
            </td>
            <td class="p-[8px] border border-solid border-[#ddd] font-bold">
              {{ item.name }}
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  name: "FormHolidayTable",
  props: {
    dataTable: { type: Array, default: [] },
    dataTableHeader: { type: Array, default: [] },
  },
  setup(props) {
    let headerTable = ref([]);

    headerTable.value = props.dataTableHeader.map((item) => {
      if (item.width) {
        item.classWidth = `w-[${item.width}]`;
      }
      return item;
    });
    return { headerTable };
  },
};
</script>

<style></style>
