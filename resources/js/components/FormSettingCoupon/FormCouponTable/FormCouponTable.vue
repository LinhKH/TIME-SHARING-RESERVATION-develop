<template>
  <div class="font-serif">
    <table class="w-full border-collapse mt-2">
      <thead>
        <tr class="">
          <th
            v-for="(item, index) in headerTable"
            :key="index"
            class="border border-[#ddd] p-[8px] text-center"
            :class="item.classWidth"
          >
            {{ item.text }}
          </th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in listCoupon" :key="index" class="text-center even:bg-zinc-50">
          <td class="p-[8px] border border-[#ddd]">{{ item.id }}</td>
          <td class="p-[8px] border border-[#ddd]">
            <div @click="handelEdit(item.id)" class="text-[#337ab7] hover:underline cursor-pointer">
              {{ item.name }}
            </div>

            <div>{{ item.memo }}</div>
          </td>
          <td class="p-[8px] border border-[#ddd]">{{ `${item.discount_percentage}%` }}</td>
          <td class="p-[8px] border border-[#ddd]">{{ item.number_of_people }}</td>
          <td class="p-[8px] border border-[#ddd]">{{ item.code }}</td>
          <td class="p-[8px] border border-[#ddd]">
            <span>{{ formatDate(item.valid_from) }}</span>
            <span class="p-1">~</span>
            <span>{{ formatDate(item.valid_to) }}</span>
          </td>
          <td class="p-[8px] border border-[#ddd]">
            <span>{{ formatDate(item.usable_from) }}</span>
            <span class="p-1">~</span>
            <span>{{ formatDate(item.usable_to) }}</span>
          </td>
          <td class="p-[8px] border border-[#ddd]">
            <i v-if="item.enabled === 1" class="fa fa-check-circle-o text-[#4cae4c] text-[18px]"></i>
            <i v-else class="fa fa-lg fa-ban text-danger js-tooltip text-[#a94442] text-[18px] translate-y-px"></i>
          </td>
          <td class="border border-[#ddd]">
            <button
              @click="handelEdit(item.id)"
              class="p-1 bg-[#fff] border border-[#ddd] rounded hover:bg-[#e6e6e6] hover:border-solid-[#adadad] py-[6px] px-[8px]"
            >
              <i class="fa fa-pencil p-1 text-[14px]"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import { ref } from "vue";
import { ROUTER_PATH } from "@/const";
import { useRouter } from "vue-router";
export default {
  name: "FormCouponTable",
  setup(props) {
    const router = useRouter();
    let headerTable = ref([]);

    headerTable.value = props.dataTable?.header.map((item) => {
      if (item.width) {
        item.classWidth = `w-[${item.width}]`;
      }
      return item;
    });
    const handelEdit = (id) => {
      router.push(`${ROUTER_PATH.ADMIN}/${ROUTER_PATH.CONFIGURATION}/${ROUTER_PATH.MANAGE_COUPON_DETAIL}?id=${id}`);
    };
    const formatDate = (date) => {
      return date
        ? `${date.toString().substr(0, 4)}/${date.toString().substr(4, 2)}/${date.toString().substr(6, 2)}`
        : "";
    };
    return { headerTable, handelEdit, ROUTER_PATH, formatDate };
  },
  props: {
    dataTable: {
      type: Array,
      default: [],
    },
    listCoupon: {
      type: Object,
      default: () => {},
    },
  },
};
</script>

<style scoped></style>
