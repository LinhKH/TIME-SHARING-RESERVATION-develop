<template>
  <div class="">
    <table class="w-full border-collapse mt-2">
      <thead>
        <tr class="">
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
        <tr v-for="(tr, index) in dataTable.data" :key="index" class="">
          <td class="p-[8px] bg-[#d9edf7] border border-solid border-[#ddd]" v-for="(td, index) in tr" :key="index">
            <div v-if="td.type == typeLinktext" :href="`${td.url}`">
              <a class="text-[#337ab7] hover:underline">{{ td.textID }}</a>
              <div>{{ td.text }}</div>
            </div>
            <div v-if="td.type == typeLinksUser">
              <div>
                <a class="text-[#337ab7] hover:underline" :href="`${td.url1}`">-</a>
              </div>
              <a class="text-[#b11515] hover:underline" :href="`${td.url2}`">
                {{ td.text }}
              </a>
            </div>
            <a class="text-[#337ab7] hover:underline" v-if="td.type == typeLinks" :href="`${td.url}`">{{ td.text }}</a>
            <div v-if="td.type == 'textIcon'">
              <i class="fa fa-building-o"></i>
              <span>{{ td.text }}</span>
            </div>
            <p v-if="td.type == typeText">
              {{ td.text }}
            </p>
          </td>
          <td class="p-[8px] bg-[#d9edf7] border border-solid border-[#ddd]">
            <div class="flex justify-center">
              <div
                class="text-[10px] w-[90%] rounded text-center py-1 bg-white border border-solid border-[#37a200] text-[#37a200] hover:bg-[#37a200] hover:text-[#fff]"
              >
                {{ $t("external_reservation.text_button") }}
              </div>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref } from "vue";
export default {
  name: "ExternalReservationTable",
  setup(props) {
    const typeLinktext = "linksText";
    const typeLinksUser = "linksUser";
    const typeLinks = "links";
    const typeText = "text";
    let headerTable = ref([]);

    headerTable.value = props.dataTable?.header.map((item) => {
      if (item.width) {
        item.classWidth = `w-[${item.width}]`;
      }
      return item;
    });
    return { headerTable, typeLinktext, typeLinksUser, typeText, typeLinks };
  },
  props: {
    dataTable: Object,
  },
};
</script>

<style scoped></style>
