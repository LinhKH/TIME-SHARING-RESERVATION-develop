<template>
  <div class="">
    <table class="w-full border-collapse mt-2">
      <thead>
        <tr class="even:bg-gray-100">
          <th
            v-for="(item, index) in headerTable"
            :key="index"
            class="border border-solid border-[#ddd] p-[8px] text-left"
            :class="item.classWidth"
          >
            {{ item.text }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="tr in dataPageList" :key="tr.id" class="even:bg-gray-100">
          <td class="p-[8px] border border-solid border-[#ddd]">
            <router-link
              class="text-[#337ab7] hover:underline"
              :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE_ADD}?id=${tr.id}`"
            >
              {{ tr.key }}
            </router-link>
          </td>
          <td class="p-[8px] border border-solid border-[#ddd]">
            <router-link
              class="text-[#337ab7] hover:underline"
              :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE_ADD}?id=${tr.id}`"
            >
              {{ tr.title }}
            </router-link>
          </td>
          <td class="p-[8px] border border-solid border-[#ddd]" >
            <router-link
              class="text-[#337ab7] hover:underline"
              :to="`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.STATIC_PAGE_ADD}?id=${tr.id}`"
            >
             <span   v-html="tr.content"></span> 
            </router-link>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ROUTER_PATH } from "@/const";
import { ref } from "vue";
export default {
  name: "StaticPageTable",
  props: {
    dataTable: { type: Array, default: [] },
    dataPageList: { type: Array, default: [] },
  },
  setup(props) {
    const typeLinks = "links";
    let headerTable = ref([]);

    headerTable.value = props.dataTable?.header.map((item) => {
      if (item.width) {
        item.classWidth = `w-[${item.width}]`;
      }
      return item;
    });
    return { headerTable, typeLinks, ROUTER_PATH };
  },
};
</script>

<style></style>
